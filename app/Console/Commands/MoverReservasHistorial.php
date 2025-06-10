<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserva;
use App\Models\HistorialReserva;
use Carbon\Carbon;

class MoverReservasHistorial extends Command
{
    protected $signature = 'reservas:mover-historial';
    protected $description = 'Mueve las reservas pasadas al historial';

    public function handle()
    {
        $reservasPasadas = Reserva::where('fecha_fin', '<', Carbon::now())->get();

        foreach ($reservasPasadas as $reserva) {
            HistorialReserva::create([
                'id_usuario' => $reserva->id_usuario,
                'id_autocaravana' => $reserva->id_autocaravana,
                'fecha_inicio' => $reserva->fecha_inicio,
                'fecha_fin' => $reserva->fecha_fin,
                'pago_realizado' => $reserva->pago_realizado,
                'porcentaje_pagado' => $reserva->porcentaje_pagado,
                'precio_total' => $reserva->precio_total
            ]);

            $reserva->delete();
        }

        $this->info("Reservas movidas al historial: {$reservasPasadas->count()}");
        return 0;
    }
}
