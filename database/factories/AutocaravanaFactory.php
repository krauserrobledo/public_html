<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AutocaravanaFactory extends Factory
{
    public function definition()
    {
        return [
            'modelo' => $this->faker->word . ' ' . $this->faker->randomElement(['Deluxe', 'Familiar', 'Premium', 'Compact']),
            'descripcion' => $this->faker->paragraph,
            'plazas' => $this->faker->numberBetween(2, 6),
            'precio_por_dia' => $this->faker->randomFloat(2, 50, 300),
            'disponible' => $this->faker->boolean(90)
        ];
    }
}