@extends('layouts.app')

@section('content')
<style>
    .header-box {
        background-color: #800000;
        color: white;
        text-align: center;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 25px;
        font-weight: bold;
        font-size: 22px;
    }

    .btn-red {
        background-color: #800000;
        color: white;
        border: none;
        font-weight: bold;
    }

    .btn-red:hover {
        background-color: #a00000;
        color: white;
    }
</style>

<div class="container">
    <div class="header-box">Agregar producto</div>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

    <form action="{{ route('existencias.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Código de barras</label>
                <input type="text" name="codigo_barras" class="form-control" value="{{ old('codigo_barras') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Nombre del producto *</label>
                <input type="text" name="nombre" class="form-control" required value="{{ old('nombre') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Precio *</label>
                <input type="number" name="precio" class="form-control" required step="0.01" value="{{ old('precio') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Costo *</label>
                <input type="number" name="costo" class="form-control" required step="0.01" value="{{ old('costo') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">IVA *</label>
                <input type="number" name="iva" class="form-control" required step="0.01" value="{{ old('iva') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Categoría *</label>
                <select name="categoria_id" class="form-control" required>
                    <option value="">Seleccione categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Unidad de venta *</label>
                <select name="unidad_venta" class="form-control" required>
                    <option value="">Seleccione unidad</option>
                    @foreach($unidadesVenta as $unidad)
                        <option value="{{ $unidad->nombre }}">{{ $unidad->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Stock *</label>
                <input type="number" name="stock" class="form-control" required value="{{ old('stock') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Stock mínimo</label>
                <input type="number" name="stock_min" class="form-control" value="{{ old('stock_min') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Imagen del producto</label>
                <input type="file" name="imagen" class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <label>
                    <input type="checkbox" name="permite_devolucion" value="1"> Permite devolución
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-red">Guardar</button>
        <a href="{{ route('existencias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
