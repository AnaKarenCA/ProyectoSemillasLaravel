@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📦 Movimientos de Inventario</h2>

    <a href="{{ route('inventarios.create') }}" class="btn btn-primary mb-3">➕ Nuevo movimiento</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Motivo</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventarios as $i)
            <tr>
                <td>{{ $i->id_inventario }}</td>
                <td>{{ $i->producto->nombre ?? 'No definido' }}</td>
                <td>{{ ucfirst($i->tipo_movimiento) }}</td>
                <td>{{ $i->cantidad }}</td>
                <td>{{ $i->unidad }}</td>
                <td>{{ $i->motivo ?? '-' }}</td>
                <td>{{ $i->fecha_movimiento }}</td>
                <td>
                    <a href="{{ route('inventarios.show', $i->id_inventario) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('inventarios.edit', $i->id_inventario) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('inventarios.destroy', $i->id_inventario) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar registro?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $inventarios->links() }}
</div>
@endsection
