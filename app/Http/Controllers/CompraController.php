<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Proveedor;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('proveedor')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedor::where('estado', 'activo')->get();
        $productos = Producto::where('estado', 'activo')->get();

        return view('compras.create', compact('proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_proveedor'   => 'required|exists:proveedores,id_proveedor',
            'folio_factura'  => 'nullable|string|max:50',
            'forma_pago'     => 'required|in:efectivo,transferencia,crédito',
            'estado_pago'    => 'required|in:pagada,pendiente',
            'fecha'          => 'required|date',
            'total'          => 'required|numeric|min:0',
            'descripcion'    => 'nullable|string|max:255',
            'observaciones'  => 'nullable|string',
            'productos'      => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            // Crear compra principal
            $compra = Compra::create([
                'id_proveedor'  => $request->id_proveedor,
                'id_usuario'    => Auth::user()->id_usuario ?? 1, // Fallback si no hay sesión
                'folio_factura' => $request->folio_factura,
                'forma_pago'    => $request->forma_pago,
                'estado_pago'   => $request->estado_pago,
                'fecha'         => $request->fecha,
                'total'         => $request->total,
                'descripcion'   => $request->descripcion,
                'observaciones' => $request->observaciones,
                'estado'        => 'activo',
            ]);

            // Guardar detalle de productos
            if ($request->productos) {
                foreach ($request->productos as $detalle) {
                    if (
                        !empty($detalle['id_producto']) &&
                        $detalle['id_producto'] > 0 &&
                        !empty($detalle['cantidad']) &&
                        $detalle['cantidad'] > 0
                    ) {
                        DetalleCompra::create([
                            'id_compra'   => $compra->id_compra,
                            'id_producto' => $detalle['id_producto'],
                            'cantidad'    => $detalle['cantidad'],
                            'costo'       => $detalle['costo'],
                        ]);

                        // Actualizar stock y costo
                        $producto = Producto::find($detalle['id_producto']);
                        if ($producto) {
                            $producto->stock += $detalle['cantidad'];
                            $producto->costo = $detalle['costo'];
                            $producto->save();
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('compras.index')
                ->with('success', 'Compra registrada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al guardar la compra: ' . $e->getMessage()]);
        }
    }

    public function edit(Compra $compra)
    {
        $proveedores = Proveedor::where('estado', 'activo')->get();
        return view('compras.edit', compact('compra', 'proveedores'));
    }

    public function update(Request $request, Compra $compra)
    {
        $validated = $request->validate([
            'id_proveedor'   => 'required|exists:proveedores,id_proveedor',
            'folio_factura'  => 'nullable|string|max:50',
            'forma_pago'     => 'required|in:efectivo,transferencia,crédito',
            'estado_pago'    => 'required|in:pagada,pendiente',
            'fecha'          => 'required|date',
            'total'          => 'required|numeric|min:0',
            'descripcion'    => 'nullable|string|max:255',
            'observaciones'  => 'nullable|string',
        ]);

        $compra->update($validated);

        return redirect()->route('compras.index')
            ->with('success', 'Compra actualizada correctamente.');
    }

    public function destroy(Compra $compra)
    {
        $compra->estado = 'inactivo';
        $compra->save();

        return redirect()->route('compras.index')
            ->with('success', 'Compra eliminada correctamente.');
    }
}
