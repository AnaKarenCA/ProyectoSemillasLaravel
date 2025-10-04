<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function index()
    {
        $usuarios   = User::select('id_usuario', 'nombre')->orderBy('nombre')->get();
        $categorias = Categoria::select('id_categoria', 'nombre')->orderBy('nombre')->get();

        return view('reportes.index', compact('usuarios', 'categorias'));
    }

    public function generar(Request $request)
    {
        $filtro     = $request->filtro ?? 'productos_mas_vendidos';
        $usuario    = $request->usuario ?? '';
        $categoria  = $request->categoria ?? '';
        $datos      = [];

        switch ($filtro) {
            case "ventas_usuario":
                $query = DB::table('ventas as v')
                    ->join('detalle_ventas as dv', 'v.id_venta', '=', 'dv.id_venta')
                    ->join('productos as p', 'dv.id_producto', '=', 'p.id_producto')
                    ->join('usuarios as u', 'v.id_usuario', '=', 'u.id_usuario')
                    ->select('v.id_venta', 'p.nombre as producto', 'dv.cantidad', 'u.nombre as nombre_usuario', 'v.fecha')
                    ->orderByDesc('v.fecha');

                if ($usuario) $query->where('v.id_usuario', $usuario);
                $datos = $query->get();
                break;

            case "productos_mas_vendidos":
                $query = DB::table('detalle_ventas as dv')
                    ->join('productos as p', 'dv.id_producto', '=', 'p.id_producto')
                    ->join('ventas as v', 'dv.id_venta', '=', 'v.id_venta')
                    ->select('p.id_producto', 'p.nombre', DB::raw('SUM(dv.cantidad) as total_vendido'))
                    ->groupBy('p.id_producto','p.nombre')
                    ->orderByDesc('total_vendido')
                    ->limit(100);

                if ($categoria) $query->where('p.categoria_id', $categoria);
                $datos = $query->get();
                break;

            case "bajo_stock":
                $query = DB::table('productos')
                    ->select('id_producto','nombre','stock')
                    ->orderBy('stock','asc')
                    ->limit(5);
                if ($categoria) $query->where('categoria_id',$categoria);
                $datos = $query->get();
                break;

            case "ventas_categoria":
                if ($categoria) {
                    $datos = DB::table('ventas as v')
                        ->join('detalle_ventas as dv', 'v.id_venta', '=', 'dv.id_venta')
                        ->join('productos as p', 'dv.id_producto', '=', 'p.id_producto')
                        ->join('categorias as c', 'p.categoria_id', '=', 'c.id_categoria')
                        ->join('usuarios as u', 'v.id_usuario', '=', 'u.id_usuario')
                        ->select('v.id_venta','p.nombre as producto','dv.cantidad','u.nombre as nombre_usuario','c.nombre as nombre_categoria','v.fecha')
                        ->where('p.categoria_id',$categoria)
                        ->orderByDesc('v.fecha')
                        ->get();
                }
                break;
        }

        return view('reportes.partials.resultado', compact('datos','filtro'));
    }
}
