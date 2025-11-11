<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Mostrar listado
    public function index()
    {
        $clientes = Cliente::orderBy('id_cliente', 'desc')->get();
        return view('clientes.index', compact('clientes'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('clientes.create');
    }

    // Guardar nuevo cliente
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'estado' => 'required|in:activo,inactivo',
            'descuento' => 'required|numeric|min:0|max:100',
        ]);

        Cliente::create($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente agregado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    // Actualizar cliente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'estado' => 'required|in:activo,inactivo',
            'descuento' => 'required|numeric|min:0|max:100',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    // Eliminar cliente
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado.');
    }
}
