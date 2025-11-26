<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\ProductoUnidad;
use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\Categoria;
use App\Models\Usuario;

class VentaController extends Controller
{
    public function index()
    {
        // Usuario autenticado
        $usuario = auth()->user();

        // Productos y unidades
        $productos = Producto::with('unidades')->get();

        // Categorías
        $categorias = Categoria::all();

        // Precio máximo para el slider (CORREGIDO)
        $maxPrecio = ProductoUnidad::max('precio');

        return view('venta.venta', compact('productos', 'usuario', 'categorias', 'maxPrecio'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // 1. Crear venta
            $venta = Venta::create([
                'id_usuario' => auth()->user()->id_usuario,
                'total'      => $request->total,
            ]);

            // 2. Recorrer productos recibidos
            foreach ($request->productos as $item) {

                $unidad = ProductoUnidad::find($item['id_producto_unidad']);

                // Cálculo proporcional en KG
                $cantidadKg = $item['cantidad'] * $unidad->factor_conversion;

                $precio = $unidad->precio;
                $subtotal = $item['cantidad'] * $precio;

                // 👉 Insertar detalle
                VentaDetalle::create([
                    'id_venta'            => $venta->id_venta,
                    'id_producto'         => $item['id_producto'],
                    'id_producto_unidad'  => $item['id_producto_unidad'],
                    'cantidad'            => $item['cantidad'],
                    'precio'              => $precio,
                    'subtotal'            => $subtotal,
                ]);

                // 👉 Descontar inventario
                $producto = Producto::find($item['id_producto']);
                $producto->existencia -= $cantidadKg;
                $producto->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Venta realizada correctamente']);

        } catch (\Exception $e) {

            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la venta',
                'error'   => $e->getMessage()
            ]);
        }
    }
}
