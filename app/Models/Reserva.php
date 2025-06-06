<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Autocaravana;
use App\Models\Pago;


class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas'; 
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'id_usuario',
        'id_autocaravana',
        'fecha_inicio',
        'fecha_fin',
        'pago_realizado',
        'porcentaje_pagado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'pago_realizado' => 'boolean'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario'); // Relación con id_usuario
    }

    public function autocaravana()
    {
        return $this->belongsTo(Autocaravana::class, 'id_autocaravana'); // Relación con id_autocaravana
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_reserva'); // Relación con pagos
    }
}
