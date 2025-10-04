<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;

class MenuController extends Controller
{
    public function obtenerMenus()
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return [];
        }

        // obtener rol
        $rol_id = $usuario->id_rolAsignado;

        // obtener menús por rol
        $menus = DB::table('menus')
            ->join('menuasignado', 'menus.id_menu', '=', 'menuasignado.id_menu')
            ->where('menuasignado.id_rol', $rol_id)
            ->where('menus.visible', 1)
            ->select('menus.nombre', 'menus.icono', 'menus.url')
            ->orderBy('menus.id_menu')
            ->get();

        return $menus;
    }
}
