<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Autocaravana;
use App\Models\User;

class ReservaController extends Controller
{
    // Mostrar listado de todas las reservas (para admin)
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'autocaravana'])->get();
        return view('admin.reservas.index', compact('reservas'));
    }

    // Mostrar formulario para crear reserva
    public function create()
    {
        $autocaravanas = Autocaravana::where('disponible','>',0)->get();
        $clientes = User::where('rol', 'cliente')->get();
        $editando = false;

        return view('admin.reservas.create', compact('autocaravanas', 'clientes', 'editando'));
    }

    // Guardar nueva reserva
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'id_autocaravana' => 'required|exists:autocaravanas,id',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        Reserva::create($validated);

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva creada correctamente.');
    }

    // Mostrar formulario para editar reserva
    public function edit(Reserva $reserva)
    {
        $clientes = User::where('rol', 'cliente')->get();
        $autocaravanas = Autocaravana::all();
        $editando = true;

        return view('admin.reservas.create', compact('reserva', 'clientes', 'autocaravanas', 'editando'));
    }

    // Actualizar reserva existente
    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        $validated = $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'id_autocaravana' => 'required|exists:autocaravanas,id',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $reserva->update($validated);

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva actualizada correctamente.');
    }

    // Eliminar una reserva
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return redirect()->route('admin.reservas.index')->with('success', 'Reserva eliminada correctamente.');
    }
}
