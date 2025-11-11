@extends('layouts.app')

@section('title', 'Proveedores')

@section('content')
<section class="hero-section text-center mb-4">
    <h1>Lista de Proveedores</h1>
</section>

<div class="container">
    <a href="{{ route('proveedores.create') }}" class="btn btn-maroon mb-3">➕ Agregar Proveedor</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped table-maroon">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proveedores as $p)
            <tr>
                <td>{{ $p->id_proveedor }}</td>
                <td>{{ $p->nombre }}</td>
                <td>{{ $p->telefono }}</td>
                <td>{{ $p->correo }}</td>
                <td>{{ $p->direccion }}</td>
                <td>{{ $p->estado }}</td>
                <td>
                    <a href="{{ route('proveedores.edit', $p->id_proveedor) }}" class="btn btn-primary btn-sm">✏️</a>
                    <form action="{{ route('proveedores.destroy', $p->id_proveedor) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar proveedor?')">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
