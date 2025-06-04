<?php

namespace Database\Factories;

use App\Models\Reserva;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagoFactory extends Factory
{
    public function definition()
    {
        return [
            'id_reserva' => Reserva::factory(),
            'metodo_pago' => $this->faker->randomElement(['Stripe', 'PayPal', 'Square', 'Revolut']),
            'cantidad_pagada' => $this->faker->randomFloat(2, 50, 500)
        ];
    }
}