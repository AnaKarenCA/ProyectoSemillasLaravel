@extends('layouts.app')

@section('title', 'Inventario y Movimientos')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<section class="hero-section text-center mb-4">
    <i class="material-icons" style="font-size: 36px; vertical-align: middle;">inventory_2</i>
    <h1 class="d-inline align-middle ms-2">Inventario y Movimientos</h1>
</section>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Botón agregar movimiento -->
    <a href="{{ route('inventarios.create') }}" class="btn btn-maroon mb-3">
        <i class="material-icons">add_box</i> Agregar Movimiento
    </a>

    <!-- Resumen de inventario -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card resumen-card p-3 shadow-sm">
                <div><i class="material-icons text-danger">category</i> <strong>Total de Productos</strong></div>
                <h4 class="mt-2">{{ $totalProductos }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card resumen-card p-3 shadow-sm">
                <div><i class="material-icons text-success">arrow_downward</i> <strong>Entradas del Mes</strong></div>
                <h4 class="mt-2">{{ $entradasMes }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card resumen-card p-3 shadow-sm">
                <div><i class="material-icons text-warning">arrow_upward</i> <strong>Salidas del Mes</strong></div>
                <h4 class="mt-2">{{ $salidasMes }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card resumen-card p-3 shadow-sm">
                <div><i class="material-icons text-danger">warning</i> <strong>Productos Críticos</strong></div>
                <h4 class="mt-2">{{ $productosCriticos->count() }}</h4>
            </div>
        </div>
    </div>

    <!-- Tabla principal -->
    <table class="table table-bordered table-striped table-maroon">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Motivo</th>
                <th>Fecha</th>
                <th style="width:160px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventarios as $i)
                <tr>
                    <td>{{ $i->id_inventario }}</td>
                    <td>{{ $i->producto->nombre ?? 'No definido' }}</td>
                    <td>{{ ucfirst($i->tipo_movimiento) }}</td>
                    <td>{{ $i->cantidad }}</td>
                    <td>{{ $i->unidad }}</td>
                    <td>{{ $i->motivo ?? '-' }}</td>
                    <td>{{ $i->fecha_movimiento }}</td>
                    <td class="text-center">
                        <a href="{{ route('inventarios.show', $i->id_inventario) }}" class="btn btn-primary btn-sm" title="Ver">
                            <i class="material-icons">visibility</i>
                        </a>
                        <a href="{{ route('inventarios.edit', $i->id_inventario) }}" class="btn btn-warning btn-sm" title="Editar">
                            <i class="material-icons">edit</i>
                        </a>
                        <form action="{{ route('inventarios.destroy', $i->id_inventario) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Eliminar registro?')">
                                <i class="material-icons">delete_forever</i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted">Sin movimientos registrados</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="mt-3">
        {{ $inventarios->links() }}
    </div>
</div>

<style>
    /* Hero rojo completo (sin bordes redondeados) */
    .hero-section {
        background-color: #800000;
        color: white;
        padding: 1.2rem;
        border-radius: 0;
        width: 100%;
    }

    .hero-section h1 {
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0;
    }

    /* Botón rojo */
    .btn-maroon {
        background-color: #800000;
        border-color: #800000;
        color: #fff;
    }

    .btn-maroon:hover {
        background-color: #a00000;
        border-color: #a00000;
        color: #fff;
    }

    /* Tabla roja */
    .table-maroon thead {
        background-color: #800000;
        color: white;
    }

    /* Tarjetas de resumen */
    .resumen-card {
        border-left: 5px solid #800000;
        background: #f9f9f9;
    }

    /* Mensaje de éxito */
    .alert-success {
        background-color: #a64d4d;
        border-color: #800000;
        color: #fff;
    }
</style>
@endsection
