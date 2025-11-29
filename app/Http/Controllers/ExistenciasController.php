<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\UnidadVenta;
use Illuminate\Support\Facades\Storage;

class ExistenciasController extends Controller
{
    /* =======================================================
        LISTADO GENERAL
    ======================================================= */
    public function index()
    {
        $productos = Producto::with('categoria')->orderBy('id_producto', 'desc')->get();
        $categorias = Categoria::all();

        return view('existencias.index', compact('productos', 'categorias'));
    }

    /* =======================================================
        FORMULARIO CREAR
    ======================================================= */
    public function create()
    {
        $categorias = Categoria::all();
        $unidadesVenta = UnidadVenta::all();

        return view('existencias.create', compact('categorias', 'unidadesVenta'));
    }

    /* =======================================================
        GUARDAR NUEVO PRODUCTO
    ======================================================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'nullable|string|max:50|unique:productos,codigo',
            'codigo_barras' => 'nullable|string|max:50|unique:productos,codigo_barras',
            'nombre' => 'required|string|max:255|unique:productos,nombre',
            'precio' => 'required|numeric|min:0',
            'costo' => 'required|numeric|min:0',
            'iva' => 'required|numeric|min:0',
            'categoria_id' => 'required|integer',
            'unidad_venta' => 'required|string',
            'stock' => 'required|numeric|min:0',
            'stock_min' => 'nullable|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Subir imagen
        if ($request->hasFile('imagen')) {
            $validated['imagenes'] = $request->file('imagen')->store('productos', 'public');
        }

        $validated['activo'] = 1;
        $validated['permite_devolucion'] = $request->has('permite_devolucion') ? 1 : 0;

        Producto::create($validated);

        return redirect()
            ->route('existencias.index')
            ->with('success', 'Producto agregado correctamente.');
    }

    /* =======================================================
        FORMULARIO EDITAR
    ======================================================= */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        $unidadesVenta = UnidadVenta::all();

        return view('existencias.edit', compact('producto', 'categorias', 'unidadesVenta'));
    }

    /* =======================================================
        ACTUALIZAR PRODUCTO
    ======================================================= */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $validated = $request->validate([
            'codigo' => 'nullable|string|max:50|unique:productos,codigo,' . $producto->id_producto . ',id_producto',
            'codigo_barras' => 'nullable|string|max:50|unique:productos,codigo_barras,' . $producto->id_producto . ',id_producto',
            'nombre' => 'required|string|max:255|unique:productos,nombre,' . $producto->id_producto . ',id_producto',
            'precio' => 'required|numeric|min:0',
            'costo' => 'required|numeric|min:0',
            'iva' => 'required|numeric|min:0',
            'categoria_id' => 'required|integer',
            'unidad_venta' => 'required|string',
            'stock' => 'required|numeric|min:0',
            'stock_min' => 'nullable|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // Si sube nueva imagen, borrar la anterior
        if ($request->hasFile('imagen')) {
            if ($producto->imagenes) {
                Storage::disk('public')->delete($producto->imagenes);
            }
            $validated['imagenes'] = $request->file('imagen')->store('productos', 'public');
        }

        $validated['permite_devolucion'] = $request->has('permite_devolucion') ? 1 : 0;

        $producto->update($validated);

        return redirect()
            ->route('existencias.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /* =======================================================
        ELIMINAR PRODUCTO
    ======================================================= */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->imagenes) {
            Storage::disk('public')->delete($producto->imagenes);
        }

        $producto->delete();

        return redirect()
            ->route('existencias.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    /* =======================================================
        DESACTIVAR
    ======================================================= */
    public function desactivar($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->activo = 0;
        $producto->save();

        return redirect()
            ->route('existencias.index')
            ->with('success', 'Producto desactivado correctamente.');
    }

    /* =======================================================
        ACTIVAR
    ======================================================= */
    public function activar($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->activo = 1;
        $producto->save();

        return redirect()
            ->route('existencias.index')
            ->with('success', 'Producto activado correctamente.');
    }
}
