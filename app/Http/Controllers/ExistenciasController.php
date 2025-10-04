<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ExistenciasController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        $categorias = Categoria::all();
        return view('existencias.index', compact('productos', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('existencias.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($data);

        return redirect()->route('existencias.index')
                         ->with('success', 'Producto agregado correctamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('existencias.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()->route('existencias.index')
                         ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('existencias.index')
                         ->with('success', 'Producto eliminado correctamente.');
    }
}
