<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\Rol;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $usuarios = Configuracion::with('rol')->get();
        $roles = Rol::all();

        return view('configuracion.index', compact('usuario', 'usuarios', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Configuracion::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'correo_electronico' => 'required|email',
            'direccion' => 'nullable|string',
            'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $usuario->fill($request->except(['contrasena', 'foto_perfil']));

        if ($request->filled('contrasena')) {
            $usuario->contrasena = Hash::make($request->contrasena);
        }

        if ($request->hasFile('foto_perfil')) {
            $path = $request->file('foto_perfil')->store('fotos', 'public');
            $usuario->foto_perfil = $path;
        }

        $usuario->save();

        return redirect()->back()->with('success', 'Datos actualizados correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'usuario' => 'required|string|unique:usuarios',
            'contrasena' => 'required|string|min:6',
            'correo_electronico' => 'required|email|unique:usuarios',
            'id_rolAsignado' => 'required|integer',
        ]);

        $nuevo = new Configuracion($request->all());
        $nuevo->contrasena = Hash::make($request->contrasena);
        $nuevo->save();

        return redirect()->back()->with('success', 'Usuario agregado correctamente.');
    }

    public function destroy($id)
    {
        Configuracion::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Usuario eliminado.');
    }
}
