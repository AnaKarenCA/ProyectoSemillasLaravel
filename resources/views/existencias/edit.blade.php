@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-white p-3" style="background-color:#A31D1D;">Editar Producto</h1>

    <form action="{{ route('existencias.update', $producto->id_producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock:</label>
            <input type="number" name="stock" class="form-control" value="{{ $producto->stock }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio:</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="{{ $producto->precio }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Costo:</label>
            <input type="number" step="0.01" name="costo" class="form-control" value="{{ $producto->costo }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control">{{ $producto->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoría:</label>
            <select name="categoria_id" class="form-select" required>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id_categoria }}" 
                        {{ $producto->categoria_id == $cat->id_categoria ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ubicación:</label>
            <input type="text" name="ubicacion" class="form-control" value="{{ $producto->ubicacion }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen:</label><br>
            @if($producto->imagen)
                <img src="{{ asset('storage/'.$producto->imagen) }}" alt="Producto" width="120" class="mb-2">
            @endif
            <input type="file" name="imagen" class="form-control">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Guardar cambios</button>
            <a href="{{ route('existencias.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
