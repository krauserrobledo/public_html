<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos'; // Nombre exacto de tu tabla
    protected $primaryKey = 'id'; // Coincide con tu estructura

    protected $fillable = [
        'id_reserva',
        'metodo_pago',
        'cantidad_pagada'
    ];

    protected $casts = [
        'fecha_pago' => 'datetime'
    ];

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva'); // Relación con id_reserva
    }
}