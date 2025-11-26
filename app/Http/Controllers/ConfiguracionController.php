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
            'correo_electronico' => 'required|email|unique:usuarios,correo_electronico,' . $id . ',id_usuario',
            'direccion' => 'nullable|string',
            'foto_perfil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ],[
            'correo_electronico.unique' => '⚠ Este correo ya está registrado por otro usuario.',
        ]);

        $usuario->fill($request->except(['contrasena', 'foto_perfil']));

        if ($request->filled('contrasena')) {
            $usuario->contrasena = Hash::make($request->contrasena);
        }

        if ($request->hasFile('foto_perfil')) {
            // Elimina foto anterior si existe
            if ($usuario->foto_perfil && Storage::disk('public')->exists($usuario->foto_perfil)) {
                Storage::disk('public')->delete($usuario->foto_perfil);
            }

            $path = $request->file('foto_perfil')->store('fotos', 'public');
            $usuario->foto_perfil = $path;
        }

        $usuario->save();

        return redirect()->back()->with('success', '✔ Datos actualizados correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'usuario' => 'required|string|max:50|unique:usuarios,usuario',
            'contrasena' => 'required|string|min:6',
            'correo_electronico' => 'required|email|max:100|unique:usuarios,correo_electronico',
            'id_rolAsignado' => 'required|integer',
        ], [
            'usuario.unique' => '⚠ Ese usuario ya existe, intenta otro nombre.',
            'correo_electronico.unique' => '⚠ Ese correo ya está registrado.',
        ]);

        $nuevo = new Configuracion($request->except('contrasena'));
        $nuevo->contrasena = Hash::make($request->contrasena);
        $nuevo->estado = "Activo";
        $nuevo->save();

        return redirect()->back()->with('success', '🎉 Usuario agregado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = Configuracion::findOrFail($id);

        // Evitar eliminarse a sí mismo
        if ($usuario->id_usuario == Auth::id()) {
            return redirect()->back()->with('error', '❌ No puedes eliminar tu propio usuario.');
        }

        // Eliminar foto si existe
        if ($usuario->foto_perfil && Storage::disk('public')->exists($usuario->foto_perfil)) {
            Storage::disk('public')->delete($usuario->foto_perfil);
        }

        $usuario->delete();

        return redirect()->back()->with('success', '🗑 Usuario eliminado correctamente.');
    }
}
