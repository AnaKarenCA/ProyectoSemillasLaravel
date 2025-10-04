@extends('layouts.app')

@section('title', 'Agregar Producto')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Agregar nuevo producto</h2>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de creación --}}
    <form action="{{ route('existencias.store') }}" method="POST" enctype="multipart/form-data" class="p-4 bg-light shadow rounded">
        @csrf

        {{-- Nombre --}}
        <div class="mb-3">
            <label class="form-label">Nombre del producto</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        {{-- Precio --}}
        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>

        {{-- Costo --}}
        <div class="mb-3">
            <label class="form-label">Costo</label>
            <input type="number" step="0.01" name="costo" class="form-control" required>
        </div>

        {{-- Unidad de venta --}}
        <div class="mb-3">
            <label class="form-label">Unidad de venta</label>
            <input type="text" name="unidad_venta" class="form-control" required>
        </div>

        {{-- Ubicación --}}
        <div class="mb-3">
            <label class="form-label">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control">
        </div>

        {{-- Estado --}}
        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-control">
                <option value="activo" selected>Activo</option>
                <option value="inactivo">Inactivo</option>
            </select>
        </div>

        {{-- Stock --}}
        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        {{-- Categoría --}}
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="categoria_id" class="form-control" required>
                <option value="">Seleccione categoría</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id_categoria }}">{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>

        {{-- Imagen --}}
        <div class="mb-3">
            <label class="form-label">Imagen (opcional)</label>
            <input type="file" name="imagen" class="form-control">
        </div>

        {{-- Botones --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('existencias.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
