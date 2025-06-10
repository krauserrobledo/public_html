<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistorialReserva;

class HistorialReservaController extends Controller
{
    public function index()
    {
        $historial = HistorialReserva::with(['usuario', 'autocaravana'])->paginate(10);

        return view('admin.historial.index', compact('historial'));
    }
}

