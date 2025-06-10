<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Autocaravana;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        // Obtener solo reservas futuras del usuario
        return $request->user()->reservas()
            ->with('autocaravana')
            ->where('fecha_fin', '>=', Carbon::now())
            ->orderBy('fecha_inicio', 'asc')
            ->get();
    }

    public function store(Request $request)
    {
        // Validar límite de 5 reservas futuras
        $reservasActivas = $request->user()->reservas()
            ->where('fecha_fin', '>=', Carbon::now())
            ->count();

        if ($reservasActivas >= 5) {
            return response()->json([
                'message' => 'Has alcanzado el limite de 5 reservas futuras'
            ], 422);
        }

        $validated = $request->validate([
            'id_autocaravana' => 'required|exists:autocaravanas,id',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);

        // Verificar disponibilidad
        $disponible = !Reserva::where('id_autocaravana', $validated['id_autocaravana'])
            ->where(function($query) use ($validated) {
                $query->whereBetween('fecha_inicio', [$validated['fecha_inicio'], $validated['fecha_fin']])
                      ->orWhereBetween('fecha_fin', [$validated['fecha_inicio'], $validated['fecha_fin']])
                      ->orWhere(function($q) use ($validated) {
                          $q->where('fecha_inicio', '<', $validated['fecha_inicio'])
                            ->where('fecha_fin', '>', $validated['fecha_fin']);
                      });
            })
            ->exists();

        if (!$disponible) {
            return response()->json([
                'message' => 'La autocaravana no esta disponible en las fechas seleccionadas'
            ], 409);
        }

        // Calcular precio total
        $autocaravana = Autocaravana::find($validated['id_autocaravana']);
        $dias = Carbon::parse($validated['fecha_inicio'])->diffInDays(Carbon::parse($validated['fecha_fin']));
        $precioTotal = $dias * $autocaravana->precio_por_dia;

        // Crear reserva
        $reserva = $request->user()->reservas()->create([
            'id_autocaravana' => $validated['id_autocaravana'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
            'precio_total' => $precioTotal,
            'pago_realizado' => false // Mantenemos este campo pero no se usará para pagos
        ]);

        return response()->json([
            'reserva' => $reserva,
            'precio_total' => $precioTotal,
            'dias' => $dias
        ], 201);
    }

    public function update(Request $request, Reserva $reserva)
    {
        // Verificar que el usuario es el dueño de la reserva
        if ($request->user()->id !== $reserva->id_usuario && $request->user()->rol !== 'admin') {
            abort(403, 'No autorizado');
        }

        $validated = $request->validate([
            'fecha_inicio' => 'sometimes|required|date|after_or_equal:today',
            'fecha_fin' => 'sometimes|required|date|after:fecha_inicio',
            'id_autocaravana' => 'sometimes|required|exists:autocaravanas,id'
        ]);

        // Verificar disponibilidad si se cambia vehículo o fechas
        if (isset($validated['id_autocaravana'])) {
            $idCaravana = $validated['id_autocaravana'];
        } else {
            $idCaravana = $reserva->id_autocaravana;
        }

        if (isset($validated['fecha_inicio'])) {
            $fechaInicio = $validated['fecha_inicio'];
        } else {
            $fechaInicio = $reserva->fecha_inicio;
        }

        if (isset($validated['fecha_fin'])) {
            $fechaFin = $validated['fecha_fin'];
        } else {
            $fechaFin = $reserva->fecha_fin;
        }

        $disponible = !Reserva::where('id_autocaravana', $idCaravana)
            ->where('id', '!=', $reserva->id)
            ->where(function($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                      ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin])
                      ->orWhere(function($q) use ($fechaInicio, $fechaFin) {
                          $q->where('fecha_inicio', '<', $fechaInicio)
                            ->where('fecha_fin', '>', $fechaFin);
                      });
            })
            ->exists();

        if (!$disponible) {
            return response()->json([
                'message' => 'El vehículo no esta disponible en las fechas seleccionadas'
            ], 409);
        }

        // Recalcular precio si cambian fechas o autocaravana
        if (isset($validated['fecha_inicio']) || isset($validated['fecha_fin']) || isset($validated['id_autocaravana'])) {
            $autocaravana = isset($validated['id_autocaravana']) ? 
                Autocaravana::find($validated['id_autocaravana']) : 
                $reserva->autocaravana;
                
            $dias = Carbon::parse($validated['fecha_inicio'] ?? $reserva->fecha_inicio)
                ->diffInDays(Carbon::parse($validated['fecha_fin'] ?? $reserva->fecha_fin));
                
            $validated['precio_total'] = $dias * $autocaravana->precio_por_dia;
        }

        $reserva->update($validated);

        return response()->json($reserva);
    }

    public function destroy(Request $request, Reserva $reserva)
    {
        // Verificar que el usuario es el dueño de la reserva o es admin
        if ($request->user()->id !== $reserva->id_usuario && $request->user()->rol !== 'admin') {
            abort(403, 'No autorizado');
        }

        $reserva->delete();

        return response()->json(null, 204);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}


}