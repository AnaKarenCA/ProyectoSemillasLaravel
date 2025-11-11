<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        $categorias = DB::table('categorias')
            ->select('id_categoria', 'nombre')
            ->get();

        $productos = DB::table('productos')
            ->select('id_producto', 'codigo', 'nombre', 'precio', 'stock', 'categoria_id', 'estado')
            ->where('estado', 'activo')
            ->get()
            ->map(function($p) {
                return (array) $p;
            })
            ->toArray();


        $maxPrecio = collect($productos)->max('precio') ?? 0;

        return view('venta.venta', compact('usuario', 'categorias', 'productos', 'maxPrecio'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'venta_data' => 'required|array|min:1',
            'venta_data.*.id' => 'required|exists:productos,id_producto',
            'venta_data.*.cantidad' => 'required|integer|min:1',
            'venta_data.*.precio' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0.01',
        ]);

        $usuario_id = Auth::id();

        DB::beginTransaction();
        try {
            $venta_id = DB::table('ventas')->insertGetId([
                'id_usuario' => $usuario_id,
                'total' => $data['total'],
                'fecha' => now(),
            ]);

            $productosActualizados = [];

            foreach ($data['venta_data'] as $item) {

                // Bloquear producto
                $producto = DB::table('productos')
                    ->where('id_producto', $item['id'])
                    ->lockForUpdate()
                    ->first();

                if (!$producto) {
                    throw new \Exception("Producto no encontrado: {$item['id']}");
                }

                // Validar stock
                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("No hay suficiente stock disponible para el producto {$producto->nombre}");
                }

                // Insertar detalle de venta
                DB::table('detalle_ventas')->insert([
                    'id_venta' => $venta_id,
                    'id_producto' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                ]);

                // Actualizar stock **sin permitir negativos**
                DB::table('productos')
                    ->where('id_producto', $item['id'])
                    ->where('stock', '>=', $item['cantidad'])
                    ->decrement('stock', $item['cantidad']);

                // Obtener nuevo stock
                $nuevoStock = DB::table('productos')
                    ->where('id_producto', $item['id'])
                    ->value('stock');

                $productosActualizados[] = [
                    'id_producto' => $item['id'],
                    'stock' => $nuevoStock,
                ];
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venta realizada con éxito',
                'productos' => $productosActualizados,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la venta: ' . $e->getMessage(),
            ]);
        }
    }
}
