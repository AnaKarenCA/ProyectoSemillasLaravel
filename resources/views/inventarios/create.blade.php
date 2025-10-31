@extends('layouts.app')

@section('content')
<div class="container">
    <h2>➕ Nuevo Movimiento de Inventario</h2>

    <form action="{{ route('inventarios.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Producto:</label>
            <select name="id_producto" class="form-control">
                <option value="">Seleccione...</option>
                @foreach($productos as $p)
                    <option value="{{ $p->id_producto }}">{{ $p->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tipo de Movimiento:</label>
            <select name="tipo_movimiento" class="form-control">
                <option value="entrada">Entrada</option>
                <option value="salida">Salida</option>
                <option value="ajuste">Ajuste</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Cantidad:</label>
            <input type="number" step="0.01" name="cantidad" class="form-control">
        </div>

        <div class="mb-3">
            <label>Unidad:</label>
            <input type="text" name="unidad" class="form-control" value="gramos">
        </div>

        <div class="mb-3">
            <label>Motivo:</label>
            <input type="text" name="motivo" class="form-control">
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('inventarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
