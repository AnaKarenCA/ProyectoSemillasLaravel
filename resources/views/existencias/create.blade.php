@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f5f5f5;
    }

    .top-bar {
        width: 100%;
        background-color: #800000;
        color: white;
        text-align: center;
        padding: 15px;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 25px;
        border-radius: 6px;
    }

    form {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
    }

    .form-label {
        font-weight: bold;
        color: #333;
    }

    input, select, textarea {
        border-radius: 6px !important;
    }

    input:focus, select:focus, textarea:focus {
        border-color: #800000 !important;
        box-shadow: 0 0 5px rgba(128,0,0,0.3) !important;
    }

    .btn-red {
        background-color: #800000 !important;
        color: white !important;
        border: none;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 6px;
    }

    .btn-red:hover {
        background-color: #a00000 !important;
    }

    .btn-secondary {
        margin-left: 10px;
        border-radius: 6px;
    }

    .alert-danger {
        border-radius: 6px;
    }
</style>


<div class="top-bar">Agregar producto</div>

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
                <label class="form-label">Código Interno</label>
                <input type="text" name="codigo" class="form-control" value="{{ old('codigo') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Código de barras</label>
                <input type="text" name="codigo_barras" class="form-control" value="{{ old('codigo_barras') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Nombre del producto *</label>
                <input type="text" name="nombre" class="form-control" required value="{{ old('nombre') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Variante</label>
                <input type="text" name="variante" class="form-control" value="{{ old('variante') }}">
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
                <label class="form-label">IVA (%) *</label>
                <input type="number" name="iva" class="form-control" required step="0.01" value="{{ old('iva',16) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Unidad base *</label>
                <select name="base_unidad" class="form-control" required>
                    <option value="">Seleccionar</option>
                    <option value="g">Gramos (g)</option>
                    <option value="kg">Kilogramos (kg)</option>
                    <option value="ml">Mililitros (ml)</option>
                    <option value="l">Litros (L)</option>
                    <option value="pieza">Pieza</option>
                    <option value="caja">Caja</option>
                    <option value="m">Metros (m)</option>
                    <option value="cm">Centímetros (cm)</option>
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

            <!-- 🚀 CATEGORÍA AGREGADA AQUÍ -->
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
                <label class="form-label">Stock *</label>
                <input type="number" name="stock" class="form-control" required step="0.001" value="{{ old('stock') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Stock mínimo</label>
                <input type="number" name="stock_min" class="form-control" step="0.001" value="{{ old('stock_min',0) }}">
            </div>


            <div class="col-md-4 mb-3">
                <label class="form-label">Proveedor</label>
                <select name="id_proveedor" class="form-control">
                    <option value="">Seleccionar proveedor</option>
                    @foreach($proveedores as $prov)
                        <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Imagen del producto</label>
                <input type="file" name="imagen" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label>
                    <input type="checkbox" name="permite_devolucion" value="1" checked>
                    Permite devolución
                </label>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-red">Guardar</button>
        <a href="{{ route('existencias.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
