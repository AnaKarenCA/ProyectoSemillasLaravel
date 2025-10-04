<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        // Resumen de ventas
        $resumen = DB::table('ventas')
            ->selectRaw('COUNT(*) AS ventas_dia, IFNULL(SUM(total),0) AS total_ingresos')
            ->whereDate('fecha', now())
            ->first();

        // Productos con bajo stock
        $productosBajoStock = DB::table('productos')
            ->select('nombre', 'stock')
            ->whereColumn('stock', '<', 'stock_min')
            ->get();

        return view('home.home', compact('usuario', 'resumen', 'productosBajoStock'));
    }
}
