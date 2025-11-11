@extends('layouts.app')

@section('title', 'Editar Compra')

@section('content')
<section class="hero-section py-5 text-center text-white">
    <h1 class="display-5 fw-bold">Editar Compra</h1>
    <p class="lead">Actualiza los datos de la compra seleccionada</p>
</section>

<div class="container my-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hubo algunos problemas con los datos.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <form action="{{ route('compras.update', $compra) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Proveedor</label>
                        <select name="id_proveedor" class="form-select" required>
                            <option value="">Selecciona un proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id_proveedor }}" 
                                    {{ $proveedor->id_proveedor == $compra->id_proveedor ? 'selected' : '' }}>
                                    {{ $proveedor->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Folio / Factura</label>
                        <input type="text" name="folio_factura" value="{{ $compra->folio_factura }}" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" value="{{ date('Y-m-d', strtotime($compra->fecha)) }}" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Forma de pago</label>
                        <select name="forma_pago" class="form-select" required>
                            <option value="efectivo" {{ $compra->forma_pago == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="transferencia" {{ $compra->forma_pago == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                            <option value="crédito" {{ $compra->forma_pago == 'crédito' ? 'selected' : '' }}>Crédito</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Estado del pago</label>
                        <select name="estado_pago" class="form-select" required>
                            <option value="pagada" {{ $compra->estado_pago == 'pagada' ? 'selected' : '' }}>Pagada</option>
                            <option value="pendiente" {{ $compra->estado_pago == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Total</label>
                        <input type="number" step="0.01" name="total" value="{{ $compra->total }}" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2">{{ $compra->descripcion }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="2">{{ $compra->observaciones }}</textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-guardar me-2">
                        <span class="material-icons align-middle">save</span> Guardar cambios
                    </button>
                    <a href="{{ route('compras.index') }}" class="btn btn-cancelar">
                        <span class="material-icons align-middle">arrow_back</span> Regresar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style>
body {
    background: url('{{ asset("images/home2.png") }}') no-repeat center center fixed;
    background-size: cover;
}
.hero-section {
    background-color: #800000;
}
.btn-guardar {
    background-color: #ce0202c3;
    color: white;
    transition: 0.3s;
}
.btn-guardar:hover {
    background-color: #800000;
    transform: scale(1.05);
}
.btn-cancelar {
    background-color: #555;
    color: white;
}
.btn-cancelar:hover {
    background-color: #333;
}
.card {
    border-radius: 15px;
}
</style>
@endsection
