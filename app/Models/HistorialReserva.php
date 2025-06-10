<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialReserva extends Model
{
    protected $table = 'historial_reservas';

    protected $fillable = [
        'id_usuario',
        'id_autocaravana',
        'fecha_inicio',
        'fecha_fin',
        'pago_realizado',
        'porcentaje_pagado',
        'movido_en',
    ];

    protected $casts = [
        'pago_realizado' => 'boolean',
        'porcentaje_pagado' => 'decimal:2',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'movido_en' => 'datetime',
    ];

    public $timestamps = false;

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function autocaravana()
    {
        return $this->belongsTo(Autocaravana::class, 'id_autocaravana');
    }
}
