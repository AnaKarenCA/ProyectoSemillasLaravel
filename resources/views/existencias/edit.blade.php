@extends('layouts.app')

@section('content')
<style>
    .top-bar {
        width: 100%;
        background-color: #800000;
        color: white;
        text-align: center;
        padding: 15px;
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 25px;
    }

    .btn-red {
        background-color: #800000 !important;
        color: white !important;
        border: none;
        font-weight: bold;
    }

    .btn-red:hover {
        background-color: #a00000 !important;
    }
</style>

<div class="top-bar">Editar producto</div>

<div class="container">
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

    <form action="{{ route('existencias.update', $producto->id_producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Código de barras</label>
                <input type="text" name="codigo_barras" class="form-control" value="{{ $producto->codigo_barras }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Nombre *</label>
                <input type="text" name="nombre" class="form-control" required value="{{ $producto->nombre }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Precio *</label>
                <input type="number" name="precio" class="form-control" required step="0.01" value="{{ $producto->precio }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Costo *</label>
                <input type="number" name="costo" class="form-control" required step="0.01" value="{{ $producto->costo }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">IVA *</label>
                <input type="number" name="iva" class="form-control" required step="0.01" value="{{ $producto->iva }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Categoría *</label>
                <select name="categoria_id" class="form-control" required>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}" {{ $producto->categoria_id == $categoria->id_categoria ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Unidad de venta *</label>
                <select name="unidad_venta" class="form-control" required>
                    @foreach($unidadesVenta as $unidad)
                        <option value="{{ $unidad->nombre }}" {{ $producto->unidad_venta == $unidad->nombre ? 'selected' : '' }}>
                            {{ $unidad->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Stock *</label>
                <input type="number" name="stock" class="form-control" required value="{{ $producto->stock }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Stock mínimo</label>
                <input type="number" name="stock_min" class="form-control" value="{{ $producto->stock_min }}">
            </div>

            <div class="col-md-4 mb-3">
            <label class="form-label">Imagen</label>
            <input type="file" name="imagen" class="form-control">

            @if($producto->imagenes)
                <div class="mt-2">
                    <p>Imagen actual:</p>
                    <img src="{{ asset('storage/' . $producto->imagenes) }}" style="width:120px; border-radius:10px;">
                </div>
            @endif
        </div>


            <div class="col-md-12 mb-3">
                <label>
                    <input type="checkbox" name="permite_devolucion" value="1" {{ $producto->permite_devolucion ? 'checked' : '' }}>
                    Permite devolución
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-red">Actualizar</button>
        <a href="{{ route('existencias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
