<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Autocaravana;
use App\Models\Reserva;
use App\Models\Pago;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Crear admin
        User::factory()->admin()->create([
            'nombre' => 'Administrador',
            'email' => 'admin@autocaravanas.com',
            'password' => bcrypt('admin123')
        ]);

        // Crear 10 usuarios normales
        $users = User::factory(10)->create();

        // Crear 15 autocaravanas
        $autocaravanas = Autocaravana::factory(15)->create();

        // Crear 30 reservas
        $reservas = Reserva::factory(30)->create();

        // Crear pagos para algunas reservas
        foreach ($reservas as $reserva) {
            if ($reserva->pago_realizado) {
                Pago::factory()->create([
                    'id_reserva' => $reserva->id,
                    'cantidad_pagada' => ($reserva->autocaravana->precio_por_dia * 
                                         $reserva->fecha_inicio->diffInDays($reserva->fecha_fin)) * 
                                         ($reserva->porcentaje_pagado / 100)
                ]);
            }
        }
    }
}