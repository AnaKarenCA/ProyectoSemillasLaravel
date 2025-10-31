<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::with('producto')->latest()->paginate(10);
        return view('inventarios.index', compact('inventarios'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('inventarios.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id_producto',
            'tipo_movimiento' => 'required|in:entrada,salida,ajuste',
            'cantidad' => 'required|numeric|min:0.01',
            'unidad' => 'nullable|string|max:50',
            'motivo' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $inventario = Inventario::create($request->all());

            // Ajuste automático del stock del producto
            $producto = $inventario->producto;
            if ($inventario->tipo_movimiento === 'entrada') {
                $producto->stock += $inventario->cantidad;
            } elseif ($inventario->tipo_movimiento === 'salida') {
                $producto->stock -= $inventario->cantidad;
            }
            $producto->save();
        });

        return redirect()->route('inventarios.index')->with('success', 'Movimiento registrado correctamente.');
    }

    public function show($id)
    {
        $inventario = Inventario::with('producto')->findOrFail($id);
        return view('inventarios.show', compact('inventario'));
    }

    public function edit($id)
    {
        $inventario = Inventario::findOrFail($id);
        $productos = Producto::all();
        return view('inventarios.edit', compact('inventario', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_producto' => 'required|exists:productos,id_producto',
            'tipo_movimiento' => 'required|in:entrada,salida,ajuste',
            'cantidad' => 'required|numeric|min:0.01',
            'unidad' => 'nullable|string|max:50',
            'motivo' => 'nullable|string|max:255',
        ]);

        $inventario = Inventario::findOrFail($id);
        $inventario->update($request->all());

        return redirect()->route('inventarios.index')->with('success', 'Movimiento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $inventario = Inventario::findOrFail($id);
        $inventario->delete();

        return redirect()->route('inventarios.index')->with('success', 'Registro eliminado.');
    }
}
