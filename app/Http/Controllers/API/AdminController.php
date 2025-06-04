<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Autocaravana;
use App\Models\HistorialReserva;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getAllReservas()
    {
        return Reserva::with(['usuario', 'autocaravana'])
                     ->orderBy('fecha_inicio', 'desc')
                     ->get();
    }

    public function getHistorial()
    {
        return HistorialReserva::with(['usuario', 'autocaravana'])
                              ->orderBy('fecha_fin', 'desc')
                              ->get();
    }

    public function manageAutocaravanas(Request $request)
    {
        $request->validate([
            'modelo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'plazas' => 'required|integer|min:1',
            'precio_por_dia' => 'required|numeric|min:0',
            'disponible' => 'boolean'
        ]);

        $autocaravana = Autocaravana::create($request->all());

        return response()->json($autocaravana, 201);
    }
}