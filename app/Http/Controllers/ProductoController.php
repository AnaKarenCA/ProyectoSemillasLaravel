<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\UnidadVenta;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['categoria', 'unidades'])->get();
        return view('existencias.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $unidadesVenta = UnidadVenta::all();

        return view('existencias.create', compact('categorias', 'unidadesVenta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo'        => 'nullable|string|max:100|unique:productos,codigo',
            'codigo_barras' => 'nullable|string|max:100|unique:productos,codigo_barras',
            'nombre'        => 'required|string|max:255|unique:productos,nombre',
            'stock'         => 'required|numeric|min:0',
            'stock_min'     => 'required|numeric|min:0',
            'base_unidad'   => 'required|in:g,ml,piece',
            'precio'        => 'required|numeric|min:0',
            'costo'         => 'required|numeric|min:0',
            'iva'           => 'nullable|numeric|min:0|max:100',
            'categoria_id'  => 'required|exists:categorias,id_categoria',
            'unidad_venta'  => 'required|string|max:50',
            'imagen'        => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['activo'] = 1;

        if ($request->hasFile('imagen')) {
            $data['imagenes'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($data);

        return redirect()
            ->route('existencias.index')
            ->with('success', 'Producto agregado correctamente');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        $unidadesVenta = UnidadVenta::all();

        return view('existencias.edit', compact('producto', 'categorias', 'unidadesVenta'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'codigo'        => "nullable|string|max:100|unique:productos,codigo,{$id},id_producto",
            'codigo_barras' => "nullable|string|max:100|unique:productos,codigo_barras,{$id},id_producto",
            'nombre'        => "required|string|max:255|unique:productos,nombre,{$id},id_producto",
            'stock'         => 'required|numeric|min:0',
            'stock_min'     => 'required|numeric|min:0',
            'base_unidad'   => 'required|in:g,ml,piece',
            'precio'        => 'required|numeric|min:0',
            'costo'         => 'required|numeric|min:0',
            'iva'           => 'nullable|numeric|min:0|max:100',
            'categoria_id'  => 'required|exists:categorias,id_categoria',
            'unidad_venta'  => 'required|string|max:50',
            'imagen'        => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // imagen nueva
        if ($request->hasFile('imagen')) {
            if ($producto->imagenes && Storage::disk('public')->exists($producto->imagenes)) {
                Storage::disk('public')->delete($producto->imagenes);
            }
            $data['imagenes'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()
            ->route('existencias.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // si tiene movimientos no borrar
        if ($producto->detalleVentas()->exists() || $producto->detalleCompras()->exists()) {
            $producto->estado = 'inactivo';
            $producto->activo = 0;
            $producto->save();

            return redirect()
                ->route('existencias.index')
                ->with('warning', 'Producto marcado como inactivo porque tiene movimientos.');
        }

        // borrar imagen
        if ($producto->imagenes && Storage::disk('public')->exists($producto->imagenes)) {
            Storage::disk('public')->delete($producto->imagenes);
        }

        $producto->delete();

        return redirect()
            ->route('existencias.index')
            ->with('success', 'Producto eliminado correctamente');
    }
}
