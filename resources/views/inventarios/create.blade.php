@extends('layouts.app')

@section('title', 'Registrar Movimiento de Inventario')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<section class="hero-section text-center mb-4">
    <i class="material-icons" style="font-size: 36px; vertical-align: middle;">add_circle_outline</i>
    <h1 class="d-inline align-middle ms-2">Registrar Movimiento de Inventario</h1>
</section>

<div class="container">
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Corrige los siguientes errores:</strong>
            <ul class="mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inventarios.store') }}" method="POST" class="card shadow-sm p-4">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="id_producto" class="form-label"><i class="material-icons align-middle">inventory_2</i> Producto</label>
                <select name="id_producto" id="id_producto" class="form-select" required>
                    <option value="">Seleccione un producto...</option>
                    @foreach($productos as $p)
                        <option value="{{ $p->id_producto }}">{{ $p->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="tipo_movimiento" class="form-label"><i class="material-icons align-middle">sync_alt</i> Tipo de Movimiento</label>
                <select name="tipo_movimiento" id="tipo_movimiento" class="form-select" required>
                    <option value="entrada">Entrada</option>
                    <option value="salida">Salida</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="cantidad" class="form-label"><i class="material-icons align-middle">format_list_numbered</i> Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label for="unidad" class="form-label"><i class="material-icons align-middle">straighten</i> Unidad</label>
                <input type="text" name="unidad" id="unidad" class="form-control" placeholder="kg, pieza, etc." required>
            </div>

            <div class="col-md-5">
                <label for="motivo" class="form-label"><i class="material-icons align-middle">description</i> Motivo</label>
                <input type="text" name="motivo" id="motivo" class="form-control" placeholder="Ej. Reabastecimiento, venta, ajuste...">
            </div>

            <div class="col-md-4">
                <label for="fecha_movimiento" class="form-label"><i class="material-icons align-middle">event</i> Fecha del Movimiento</label>
                <input type="date" name="fecha_movimiento" id="fecha_movimiento" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-maroon me-2">
                <i class="material-icons align-middle">save</i> Guardar
            </button>
            <a href="{{ route('inventarios.index') }}" class="btn btn-secondary">
                <i class="material-icons align-middle">arrow_back</i> Volver
            </a>
        </div>
    </form>
</div>

<style>
    /* Encabezado rojo */
    .hero-section {
        background-color: #800000;
        color: white;
        padding: 1.2rem;
        border-radius: 0;
        width: 100%;
    }

    .hero-section h1 {
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0;
    }

    /* Botones */
    .btn-maroon {
        background-color: #800000;
        border-color: #800000;
        color: #fff;
    }

    .btn-maroon:hover {
        background-color: #a00000;
        border-color: #a00000;
        color: #fff;
    }

    /* Card */
    .card {
        border-top: 4px solid #800000;
    }

    /* Alertas */
    .alert-danger {
        background-color: #f5c6cb;
        border-color: #800000;
        color: #800000;
    }

    /* Inputs */
    label i {
        color: #800000;
        margin-right: 4px;
    }
</style>
@endsection
