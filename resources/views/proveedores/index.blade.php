@extends('layouts.app')

@section('title', 'Lista de Proveedores')

@section('content')
<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <h2>Proveedores</h2>
        <a href="{{ route('proveedores.create') }}" class="btn btn-primary">Agregar Proveedor</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th width="160px">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proveedores as $proveedor)
                <tr>
                    <td>{{ $proveedor->id_proveedor }}</td>
                    <td>{{ $proveedor->nombre }}</td>
                    <td>{{ $proveedor->telefono ?? '—' }}</td>
                    <td>{{ $proveedor->correo ?? '—' }}</td>
                    <td>{{ $proveedor->direccion ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $proveedor->estado == 'Activo' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $proveedor->estado }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('proveedores.edit', $proveedor->id_proveedor) }}" class="btn btn-warning btn-sm">✏ Editar</a>

                        <form action="{{ route('proveedores.destroy', $proveedor->id_proveedor) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar proveedor?')">
                                🗑 Borrar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No hay proveedores registrados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
