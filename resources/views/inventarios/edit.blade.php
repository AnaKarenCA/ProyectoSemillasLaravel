@extends('layouts.app')

@section('content')
<div class="container">
    <h2>✏️ Editar Movimiento</h2>

    <form action="{{ route('inventarios.update', $inventario->id_inventario) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Producto:</label>
            <select name="id_producto" class="form-control">
                @foreach($productos as $p)
                    <option value="{{ $p->id_producto }}" {{ $p->id_producto == $inventario->id_producto ? 'selected' : '' }}>
                        {{ $p->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tipo de Movimiento:</label>
            <select name="tipo_movimiento" class="form-control">
                <option value="entrada" {{ $inventario->tipo_movimiento == 'entrada' ? 'selected' : '' }}>Entrada</option>
                <option value="salida" {{ $inventario->tipo_movimiento == 'salida' ? 'selected' : '' }}>Salida</option>
                <option value="ajuste" {{ $inventario->tipo_movimiento == 'ajuste' ? 'selected' : '' }}>Ajuste</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Cantidad:</label>
            <input type="number" step="0.01" name="cantidad" value="{{ $inventario->cantidad }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Unidad:</label>
            <input type="text" name="unidad" value="{{ $inventario->unidad }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Motivo:</label>
            <input type="text" name="motivo" value="{{ $inventario->motivo }}" class="form-control">
        </div>

        <button class="btn btn-success">Actualizar</button>
        <a href="{{ route('inventarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
