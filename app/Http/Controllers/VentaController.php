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
            ->select('id_producto', 'nombre', 'precio', 'stock', 'categoria_id')
            ->where('estado', 'activo')
            ->get()
            ->map(function($p) {
                return (array) $p;  // Convierte a array
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

            foreach ($data['venta_data'] as $item) {
                DB::table('detalle_ventas')->insert([
                    'id_venta' => $venta_id,
                    'id_producto' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                ]);

                DB::table('productos')
                    ->where('id_producto', $item['id'])
                    ->decrement('stock', $item['cantidad']);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Venta realizada con éxito']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => 'Error al procesar la venta: ' . $e->getMessage()]);
        }
    }
}
