@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📋 Detalle del Movimiento</h2>

    <ul class="list-group">
        <li class="list-group-item"><strong>Producto:</strong> {{ $inventario->producto->nombre ?? 'No definido' }}</li>
        <li class="list-group-item"><strong>Tipo:</strong> {{ ucfirst($inventario->tipo_movimiento) }}</li>
        <li class="list-group-item"><strong>Cantidad:</strong> {{ $inventario->cantidad }} {{ $inventario->unidad }}</li>
        <li class="list-group-item"><strong>Motivo:</strong> {{ $inventario->motivo ?? '-' }}</li>
        <li class="list-group-item"><strong>Fecha:</strong> {{ $inventario->fecha_movimiento }}</li>
    </ul>

    <a href="{{ route('inventarios.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
