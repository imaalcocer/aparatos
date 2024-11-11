<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Marcas;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index()
    {
        return Inertia::render('Productos/Index', [
            'productos' => Productos::paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('Productos/Create', [
            'marcas' => Marcas::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_producto' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'marca_id' => 'required|exists:marcas,id',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('img', 'public');
            $validated['image'] = $imagePath;
        } else {
            return back()->withErrors(['image' => 'La imagen es requerida']);
        }

        Productos::create($validated);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function show(Productos $producto)
    {
        $producto->load('marcas');
        return Inertia::render('Productos/Show', [
            'producto' => $producto
        ]);
    }

    public function edit(Productos $producto)
    {
        return Inertia::render('Productos/Edit', [
            'producto' => $producto,
            'marcas' => Marcas::all(),
            'marcaOfProducto' => $producto->marcas
        ]);
    }

    public function update(Request $request, Productos $producto)
    {
        $validated = $request->validate([
            'codigo_producto' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'marca_id' => 'required|exists:marcas,id',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('img', 'public');
            $validated['image'] = $imagePath;
        } else {
            unset($validated['image']);
        }

        $producto->update($validated);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Productos $producto)
    {
        \Log::info('Intentando eliminar el producto con ID: ' . $producto->id);
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente.');
    }
}
