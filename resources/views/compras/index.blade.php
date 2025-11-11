@extends('layouts.app')

@section('title', 'Compras')

@section('content')
<section class="hero-section py-5 text-center text-white">
    <h1 class="display-5 fw-bold">Registro de Compras</h1>
</section>

<div class="container my-4">
    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <a href="{{ route('compras.create') }}" class="btn btn-nuevo mb-3">
        <span class="material-icons align-middle me-1">add_shopping_cart</span> Nueva Compra
    </a>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Proveedor</th>
                        <th>Folio / Ticket</th>
                        <th>Forma Pago</th>
                        <th>Estado Pago</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($compras as $compra)
                        <tr class="{{ $compra->estado === 'inactivo' ? 'table-secondary' : '' }}">
                            <td>{{ $compra->id_compra }}</td>
                            <td>{{ $compra->proveedor->nombre ?? '—' }}</td>
                            <td>{{ $compra->folio_factura ?? '—' }}</td>
                            <td>{{ ucfirst($compra->forma_pago) }}</td>
                            <td>
                                <span class="badge bg-{{ $compra->estado_pago == 'pagada' ? 'success' : 'warning' }}">
                                    {{ ucfirst($compra->estado_pago) }}
                                </span>
                            </td>
                            <td>{{ date('d/m/Y', strtotime($compra->fecha)) }}</td>
                            <td>${{ number_format($compra->total, 2) }}</td>
                            <td class="text-center">
                                <a href="{{ route('compras.edit', $compra) }}" class="btn btn-editar btn-sm me-1">
                                    <span class="material-icons">edit</span>
                                </a>
                                <form action="{{ route('compras.destroy', $compra) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-eliminar btn-sm" onclick="return confirm('¿Inactivar compra?')">
                                        <span class="material-icons">delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">No hay compras registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
body {
    background: url('{{ asset("images/home2.png") }}') no-repeat center center fixed;
    background-size: cover;
}
.hero-section {
    background-color: #800000;
}
.btn-nuevo { background-color: #ce0202c3; color: #fff; }
.btn-nuevo:hover { background-color: #800000; color: #fff; transform: scale(1.03); }
.btn-editar { background-color: #8db848; }
.btn-eliminar { background-color: #ea2a3d; }
.btn:hover { transform: scale(1.05); }
.table-dark th { background-color: #800000 !important; }
</style>
@endsection
