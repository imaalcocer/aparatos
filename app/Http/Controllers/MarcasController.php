<?php

namespace App\Http\Controllers;

use App\Models\Marcas;
use Inertia\Inertia;
use Illuminate\Http\Request;

class MarcasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = Marcas::with('productos')->get();
        return Inertia::render('Marcas/Index', [
            'marcas' => $marcas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:80',
            'country' => 'required|max:80',
            'created_at' => 'required|date',
        ]);

        $marcas = new Marcas($request->all());
        $marcas->save();
        return redirect()->route('marcas.index')->with('success', 'Marca creada exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marcas $marca)
    {
        $request->validate([
            'name' => 'required|max:80',
            'country' => 'required|max:80',
            'created_at' => 'required|date',
        ]);
    
        $marca->update($request->only(['name', 'country', 'created_at']));
        return redirect()->route('marcas.index')->with('success', 'Marca actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marcas $marca)
    {
        $marca->delete();
        return redirect()->route('marcas.index')->with('success', 'Marca eliminada exitosamente.');
    }
}
