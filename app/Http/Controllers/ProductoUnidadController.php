<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ProductoUnidad;
use Illuminate\Http\Request;

class ProductoUnidadController extends Controller
{
    public function store(Request $request, $id_producto)
    {
        $producto = Producto::findOrFail($id_producto);

        $factor = $request->factor_conversion;
        $precioBase = $producto->precio_base_kg;

        // precio proporcional
        $precioUnitario = $precioBase * $factor;

        ProductoUnidad::create([
            'id_producto' => $id_producto,
            'unidad' => $request->unidad,
            'factor_conversion' => $factor,
            'precio_unitario' => $precioUnitario,
        ]);

        return back()->with('ok', 'Unidad añadida correctamente');
    }
}
