@extends('layouts.app')

@section('title', 'Nueva Compra')

@section('content')
<section class="hero-section py-5 text-center text-white">
    <h1 class="display-6 fw-bold">Registrar Nueva Compra</h1>
</section>

<div class="container my-5">
    <div class="card p-4 shadow-lg border-0">
        <form action="{{ route('compras.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="id_proveedor" class="form-label">Proveedor</label>
                <select name="id_proveedor" class="form-select">
                    <option value="">Seleccione un proveedor</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id_proveedor }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_compra" class="form-label">Fecha de Compra</label>
                <input type="date" name="fecha_compra" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="total" class="form-label">Total</label>
                <input type="number" name="total" step="0.01" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" name="descripcion" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('compras.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
