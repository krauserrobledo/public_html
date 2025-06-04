<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ValidateReservation
{
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);

        $inicio = Carbon::parse($request->fecha_inicio);
        $fin = Carbon::parse($request->fecha_fin);

        // Validación de antelación (60 días máximo)
        if ($inicio->diffInDays(now()) > 60) {
            return redirect()->back()
                ->withErrors(['fecha_inicio' => 'Máximo 60 días de antelación'])
                ->withInput();
        }

        // Validación de duración mínima
        if ($inicio->between(Carbon::create(2025, 7, 1), Carbon::create(2025, 8, 31))) {

            if ($inicio->diffInDays($fin) < 7) {
                return redirect()->back()
                    ->withErrors(['fecha_fin' => 'En verano (julio-agosto) la reserva mínima es 7 días'])
                    ->withInput();
            }
        } elseif ($inicio->diffInDays($fin) < 2) {
            return redirect()->back()
                ->withErrors(['fecha_fin' => 'Duración mínima: 2 días'])
                ->withInput();
        }

        return $next($request);
    }
}