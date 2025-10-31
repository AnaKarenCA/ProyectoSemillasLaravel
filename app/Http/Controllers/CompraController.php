<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('proveedor')->get();
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::all();
        return view('compras.create', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_proveedor' => 'nullable|exists:proveedores,id_proveedor',
            'fecha_compra' => 'required|date',
            'total' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Compra::create($validated);
        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
    }

    public function show(Compra $compra)
    {
        return view('compras.show', compact('compra'));
    }

    public function edit(Compra $compra)
    {
        $proveedores = Proveedor::all();
        return view('compras.edit', compact('compra', 'proveedores'));
    }

    public function update(Request $request, Compra $compra)
    {
        $validated = $request->validate([
            'id_proveedor' => 'nullable|exists:proveedores,id_proveedor',
            'fecha_compra' => 'required|date',
            'total' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $compra->update($validated);
        return redirect()->route('compras.index')->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy(Compra $compra)
    {
        $compra->delete();
        return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
    }
}
