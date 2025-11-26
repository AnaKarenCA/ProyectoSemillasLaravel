@extends('layouts.app')

@section('title', isset($proveedor) ? 'Editar Proveedor' : 'Agregar Proveedor')

@section('content')
<div class="container mt-4">
    <div class="hero-section mb-3">
        <h2>{{ isset($proveedor) ? 'Editar Proveedor' : 'Agregar Proveedor' }}</h2>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Error:</strong><br>
        @foreach ($errors->all() as $error)
            • {{ $error }} <br>
        @endforeach
    </div>
@endif

    <form action="{{ isset($proveedor) ? route('proveedores.update', $proveedor->id_proveedor) : route('proveedores.store') }}" method="POST">
        @csrf
        @if(isset($proveedor))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="nombre" class="form-label fw-bold">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ $proveedor->nombre ?? old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label fw-bold">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ $proveedor->telefono ?? old('telefono') }}">
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label fw-bold">Correo</label>
            <input type="email" name="correo" class="form-control" value="{{ $proveedor->correo ?? old('correo') }}">
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label fw-bold">Dirección</label>
            <textarea name="direccion" class="form-control">{{ $proveedor->direccion ?? old('direccion') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label fw-bold">Estado</label>
            <select name="estado" class="form-select">
                <option value="Activo" {{ (isset($proveedor) && $proveedor->estado=='Activo') ? 'selected' : '' }}>Activo</option>
                <option value="Inactivo" {{ (isset($proveedor) && $proveedor->estado=='Inactivo') ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-maroon">{{ isset($proveedor) ? 'Actualizar' : 'Guardar' }}</button>
        <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
