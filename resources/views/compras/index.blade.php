@extends('layouts.app')

@section('title', 'Compras')

@section('content')
<section class="hero-section py-5 mb-4 text-center text-white">
    <h1 class="display-5 fw-bold">Registro de Compras</h1>
    <p class="lead">Consulta las compras realizadas a proveedores</p>
</section>

<div class="container mb-5">
    <a href="{{ route('compras.create') }}" class="btn btn-success mb-3">+ Nueva Compra</a>
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Proveedor</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compras as $compra)
                        <tr>
                            <td>{{ $compra->id_compra }}</td>
                            <td>{{ $compra->proveedor->nombre ?? 'Sin asignar' }}</td>
                            <td>{{ $compra->fecha_compra }}</td>
                            <td>${{ number_format($compra->total, 2) }}</td>
                            <td>{{ $compra->descripcion }}</td>
                            <td class="text-center">
                                <a href="{{ route('compras.edit', $compra) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('compras.destroy', $compra) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar compra?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
body {
    background: url('{{ asset("images/home2.png") }}') no-repeat center center fixed;
    background-size: cover;
}
.hero-section {
    background-color: #800000;
    color: #fff;
    width: 100%;
    margin-top: -24px;
}
.table-dark th {
    background-color: #800000 !important;
}
</style>
@endsection
