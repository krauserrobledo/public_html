<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Autocaravana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservaClienteController extends Controller
{
    // Mostrar reservas futuras del cliente
    public function index()
    {
        $reservas = Reserva::where('id_usuario', Auth::id())
            ->with('autocaravana')
            ->where('fecha_fin', '>=', Carbon::now())
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        $reservasPasadas = Reserva::where('id_usuario', Auth::id())
            ->with('autocaravana')
            ->where('fecha_fin', '<', Carbon::now())
            ->orderBy('fecha_inicio', 'desc')
            ->get();
            
        return view('reservas.index', compact('reservas', 'reservasPasadas'));
    }

    // Formulario para crear reserva
    public function create()
    {
        // Verificar límite de 5 reservas futuras
        $reservasActivas = Reserva::where('id_usuario', Auth::id())
            ->where('fecha_fin', '>=', Carbon::now())
            ->count();

        if ($reservasActivas >= 5) {
            return redirect()->route('reservas.index')
                ->with('error', 'Has alcanzado el límite de 5 reservas futuras');
        }

        $autocaravanas = Autocaravana::where('disponible', '>', 0)->get();
        return view('reservas.create', [
            'autocaravanas' => $autocaravanas,
            'editando' => false,
        ]);
    }

    // Guardar nueva reserva del cliente
    public function store(Request $request)
    {
        // Validar límite de 5 reservas futuras
        $reservasActivas = Reserva::where('id_usuario', Auth::id())
            ->where('fecha_fin', '>=', Carbon::now())
            ->count();

        if ($reservasActivas >= 5) {
            return redirect()->back()
                ->with('error', 'Has alcanzado el límite de 5 reservas futuras')
                ->withInput();
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
            return redirect()->back()
                ->with('error', 'La autocaravana no está disponible en las fechas seleccionadas')
                ->withInput();
        }

        // Calcular precio total
        $autocaravana = Autocaravana::find($validated['id_autocaravana']);
        $dias = Carbon::parse($validated['fecha_inicio'])->diffInDays(Carbon::parse($validated['fecha_fin']));
        $precioTotal = $dias * $autocaravana->precio_por_dia;

        // Crear reserva
        Reserva::create([
            'id_usuario' => Auth::id(),
            'id_autocaravana' => $validated['id_autocaravana'],
            'fecha_inicio' => $validated['fecha_inicio'],
            'fecha_fin' => $validated['fecha_fin'],
            'precio_total' => $precioTotal,
            'pago_realizado' => false
        ]);

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva creada correctamente.');
    }

    // Formulario para editar reserva
    public function edit($id)
    {
        $reserva = Reserva::where('id', $id)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();
            
        $autocaravanas = Autocaravana::where('disponible', '>', 0)->get();
        $editando = true;

        return view('reservas.create', compact('reserva', 'autocaravanas', 'editando'));
    }

    // Actualizar reserva
    public function update(Request $request, $id)
    {
        $reserva = Reserva::where('id', $id)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'id_autocaravana' => 'sometimes|required|exists:autocaravanas,id',
            'fecha_inicio' => 'sometimes|required|date|after_or_equal:today',
            'fecha_fin' => 'sometimes|required|date|after:fecha_inicio'
        ]);

        // Verificar disponibilidad si se cambia vehículo o fechas
        $idCaravana = $validated['id_autocaravana'] ?? $reserva->id_autocaravana;
        $fechaInicio = $validated['fecha_inicio'] ?? $reserva->fecha_inicio;
        $fechaFin = $validated['fecha_fin'] ?? $reserva->fecha_fin;

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
            return redirect()->back()
                ->with('error', 'El vehículo no está disponible en las fechas seleccionadas')
                ->withInput();
        }

        // Recalcular precio si cambian fechas o autocaravana
        if (isset($validated['fecha_inicio'])) {
            $fechaInicio = $validated['fecha_inicio'];
        }
        if (isset($validated['fecha_fin'])) {
            $fechaFin = $validated['fecha_fin'];
        }
        
        $autocaravana = isset($validated['id_autocaravana']) ? 
            Autocaravana::find($validated['id_autocaravana']) : 
            $reserva->autocaravana;
            
        $dias = Carbon::parse($fechaInicio)->diffInDays(Carbon::parse($fechaFin));
        $validated['precio_total'] = $dias * $autocaravana->precio_por_dia;

        $reserva->update($validated);

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva actualizada correctamente.');
    }

    // Eliminar reserva
    public function destroy($id)
    {
        $reserva = Reserva::where('id', $id)
            ->where('id_usuario', Auth::id())
            ->firstOrFail();

        $reserva->delete();

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva eliminada correctamente.');
    }
}