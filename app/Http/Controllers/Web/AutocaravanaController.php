<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Autocaravana; 

class AutocaravanaController extends Controller
{
    // Mostrar listado
    public function index()
    {
        $autocaravanas = Autocaravana::all();
        return view('admin.autocaravanas', compact('autocaravanas'));
    }

    // Mostrar formulario para crear
    public function create()
    {
        return view('admin.formulario_autocaravanas', ['autocaravana' => null]);
    }

    // Guardar nueva autocaravana
    public function store(Request $request)
    {
        $validated = $request->validate([
            'modelo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'plazas' => 'required|integer|min:1',
            'precio_por_dia' => 'required|numeric|min:0',

        ]);

        $validated['disponible'] = $request->has('disponible');

        Autocaravana::create($validated);

        return redirect()->route('admin.autocaravanas.index')->with('success', 'Autocaravana creada correctamente.');
    }

    // Mostrar formulario para editar
    public function edit($id)
    {
        $autocaravana = Autocaravana::findOrFail($id);
        return view('admin.formulario_autocaravanas', compact('autocaravana'));
    }

    // Actualizar autocaravana
    public function update(Request $request, $id)
    {
        $autocaravana = Autocaravana::findOrFail($id);

        $validated = $request->validate([
            'modelo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'plazas' => 'required|integer|min:1',
            'precio_por_dia' => 'required|numeric|min:0',

        ]);
        


        $validated['disponible'] = $request->has('disponible');

        $autocaravana->update($validated);

        return redirect()->route('admin.autocaravanas.index')->with('success', 'Autocaravana actualizada correctamente.');
    }

    // Eliminar autocaravana
    public function destroy($id)
    {
        $autocaravana = Autocaravana::findOrFail($id);
        $autocaravana->delete();

        return redirect()->route('admin.autocaravanas.index')->with('success', 'Autocaravana eliminada correctamente.');
    }
}
