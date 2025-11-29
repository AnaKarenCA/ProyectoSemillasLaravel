<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\ProductoUnidad;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
{
    $compras = Compra::with('proveedor')->orderBy('id_compra', 'desc')->get();
    $productos = Producto::with('unidades')->get();

    return view('compras.index', compact('compras', 'productos'));
}


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $compra = Compra::create([
                'fecha' => now(),
                'total' => 0
            ]);

            $totalCompra = 0;

            foreach ($request->productos as $item) {

                $unidad = ProductoUnidad::find($item['id_producto_unidad']);
                $producto = Producto::find($item['id_producto']);

                if (!$unidad || !$producto) {
                    continue;
                }

                // Conversión proporcional a kilos
                $cantidadKg = $item['cantidad'] * $unidad->factor_conversion;

                // Precio proporcional según unidad comprada
                $precio = $unidad->precio_unitario;

                // Subtotal
                $subtotal = $item['cantidad'] * $precio;

                // Guardar detalle de compra
                DetalleCompra::create([
                    'id_compra' => $compra->id,
                    'id_producto' => $producto->id_producto,
                    'id_producto_unidad' => $unidad->id_producto_unidad,
                    'cantidad' => $item['cantidad'],
                    'cantidad_convertida_kg' => $cantidadKg,
                    'precio' => $precio,
                    'subtotal' => $subtotal,
                ]);

                // Actualizar inventario sumando en kilos base
                $producto->existencia += $cantidadKg;
                $producto->save();

                $totalCompra += $subtotal;
            }

            // Actualizar total de la compra
            $compra->total = $totalCompra;
            $compra->save();

            DB::commit();

            return redirect()->route('compras.index')->with('ok', 'Compra registrada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error en la compra: ' . $e->getMessage());
        }
    }
    public function create()
{
    $proveedores = \App\Models\Proveedor::where('estado', 'Activo')->get();
    $productos = \App\Models\Producto::where('estado', 'activo')->get();

    return view('compras.create', compact('proveedores', 'productos'));
}

public function edit($id)
{
    $compra = \App\Models\Compra::with('detalles.producto')->findOrFail($id);
    $proveedores = \App\Models\Proveedor::where('estado', 'Activo')->get();
    $productos = \App\Models\Producto::where('estado', 'activo')->get();

    return view('compras.edit', compact('compra', 'proveedores', 'productos'));
}

public function destroy($id)
{
    $compra = \App\Models\Compra::findOrFail($id);
    $compra->delete();

    return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
}

}
