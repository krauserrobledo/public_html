<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nombre' => 'Admin',
            'email' => 'admin@autocaravanas.com',
            'password' => bcrypt('admin123'),
            'rol' => 'admin'
        ]);
    }
}