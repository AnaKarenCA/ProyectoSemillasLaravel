<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $productos = Producto::where('activo', 1)->get();
        return view('venta.venta', compact('productos'));
    }

    public function guardarVenta(Request $request)
    {
        try {
            DB::beginTransaction();

            $carrito = $request->carrito;

            if (!$carrito || count($carrito) == 0) {
                return response()->json(['error' => 'El carrito está vacío'], 400);
            }

            $venta = Venta::create([
                'total' => $request->total,
            ]);

            foreach ($carrito as $item) {

                $producto = Producto::find($item['id']);

                if (!$producto) {
                    DB::rollBack();
                    return response()->json(['error' => 'Producto no encontrado'], 404);
                }

                if ($producto->stock < $item['cantidad']) {
                    DB::rollBack();
                    return response()->json([
                        'error' => "Stock insuficiente para {$producto->nombre}"
                    ], 400);
                }

                $producto->stock -= $item['cantidad'];
                $producto->save();

                VentaDetalle::create([
                    'id_venta' => $venta->id,
                    'id_producto' => $producto->id_producto,
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();
            return response()->json(['success' => 'Venta realizada correctamente']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
