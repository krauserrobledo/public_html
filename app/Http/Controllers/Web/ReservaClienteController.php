<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Autocaravana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReservaClienteController extends Controller{
    

    // Mostrar reservas del cliente
    public function index()
    {
        $reservas = Reserva::where('id_usuario', Auth::id())->get();
        return view('reservas.index', compact('reservas'));
    }

    // Formulario para crear reserva
    public function create()
    {
        $autocaravanas = Autocaravana::where('disponible','>',0)->get();
        return view('reservas.create', [
            'autocaravanas' => $autocaravanas,
            'editando' => false,
        ]);
    }

    // Guardar nueva reserva del cliente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_autocaravana' => 'required|exists:autocaravanas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $validated['id_usuario'] = Auth::id();

        Reserva::create($validated);

        return redirect()->route('reservas.index')->with('success', 'Reserva creada correctamente.');
    }

    // Formulario para editar reserva (solo si pertenece al cliente)
    public function edit($id)
    {
        $reserva = Reserva::where('id', $id)
                          ->where('id_usuario', Auth::id())
                          ->firstOrFail();
                          $autocaravanas = Autocaravana::all();
                          $editando = true;

                          return view('reservas.create', compact('reserva', 'autocaravanas', 'editando'));
                        }

    // Actualizar reserva (solo si pertenece al cliente)
    public function update(Request $request, $id)
    {
        $reserva = Reserva::where('id', $id)
                          ->where('id_usuario', Auth::id())
                          ->firstOrFail();

        $validated = $request->validate([
            'id_autocaravana' => 'required|exists:autocaravanas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $reserva->update($validated);

        return redirect()->route('reservas.index')->with('success', 'Reserva actualizada correctamente.');
    }

    // Eliminar reserva (solo si pertenece al cliente)
    public function destroy($id)
    {
        $reserva = Reserva::where('id', $id)
                          ->where('id_usuario', Auth::id())
                          ->firstOrFail();

        $reserva->delete();

        return redirect()->route('reservas.index')->with('success', 'Reserva eliminada correctamente.');
    }
}