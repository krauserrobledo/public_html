<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autocaravana extends Model
{
    use HasFactory;

    protected $table = 'autocaravanas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'modelo',
        'descripcion',
        'plazas',
        'precio_por_dia',
        'disponible'
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_autocaravana'); // Relación con id_autocaravana
    }
}
