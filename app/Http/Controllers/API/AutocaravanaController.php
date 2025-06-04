<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Autocaravana;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AutocaravanaController extends Controller
{
    public function disponibles(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);

        // Validar normas de reserva
        $this->validarNormasReserva($request->fecha_inicio, $request->fecha_fin);

        // Obtener vehículos ocupados en el rango de fechas
        $ocupadas = Reserva::where(function($query) use ($request) {
            $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])
                  ->orWhereBetween('fecha_fin', [$request->fecha_inicio, $request->fecha_fin])
                  ->orWhere(function($q) use ($request) {
                      $q->where('fecha_inicio', '<', $request->fecha_inicio)
                        ->where('fecha_fin', '>', $request->fecha_fin);
                  });
        })->pluck('id_autocaravana');

        // Devolver vehículos disponibles
        return Autocaravana::whereNotIn('id', $ocupadas)
                      ->where('disponible', true)
                      ->get();
    }

    private function validarNormasReserva($fechaInicio, $fechaFin)
    {
        $inicio = Carbon::parse($fechaInicio);
        $fin = Carbon::parse($fechaFin);
        $diasReserva = $inicio->diffInDays($fin);
        $diasAntelacion = Carbon::now()->diffInDays($inicio);

        // Validar duración mínima
        if ($diasReserva < 2) {
            abort(422, 'La reserva debe ser de al menos 2 días');
        }

        // Validar meses de verano
        if (in_array($inicio->month, [7, 8]) && $diasReserva < 7) {
            abort(422, 'En julio y agosto la reserva mínima es de 7 días');
        }

        // Validar antelación máxima
        if ($diasAntelacion > 60) {
            abort(422, 'No se puede reservar con más de 60 días de antelación');
        }
    }
}