@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Editar Cliente</h3>
    <form action="{{ route('clientes.update', $cliente->id_cliente) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nombre*</label>
            <input type="text" name="nombre" class="form-control" value="{{ $cliente->nombre }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ $cliente->telefono }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" value="{{ $cliente->correo }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" value="{{ $cliente->direccion }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="activo" {{ $cliente->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ $cliente->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Descuento (%)</label>
            <input type="number" step="0.01" name="descuento" class="form-control" value="{{ $cliente->descuento }}">
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
