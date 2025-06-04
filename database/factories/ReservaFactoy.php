<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Autocaravana;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class ReservaFactory extends Factory
{
    public function definition()
    {
        $fechaInicio = Carbon::now()->addDays(rand(1, 30));
        $fechaFin = $fechaInicio->copy()->addDays(rand(2, 14));

        return [
            'id_usuario' => User::factory(),
            'id_autocaravana' => Autocaravana::factory(),
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'pago_realizado' => $this->faker->boolean(80),
            'porcentaje_pagado' => $this->faker->randomElement([0, 20, 100])
        ];
    }
}