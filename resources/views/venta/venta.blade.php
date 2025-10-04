@extends('layouts.app')

@section('title', 'Punto de Venta')

@section('content')
<link rel="stylesheet" href="{{ asset('css/venta.css') }}">

<div class="container-fluid p-0"> <!-- Para que abarque todo -->
    <section class="hero-section py-4">
        <h1>Punto de Venta</h1>
        <p>Usuario: {{ $usuario->nombre ?? 'Usuario Desconocido' }}</p>

  
    </section>

    <div class="container mt-4" id="venta-module">
        <div class="info d-flex justify-content-between mb-3">
            <div>Fecha: <span id="date-field"></span></div>
            <div>Hora: <span id="time-field"></span></div>
        </div>

        <div class="search-section d-flex flex-wrap gap-2 mb-3">
            <input type="text" id="product-search" class="form-control w-auto" placeholder="Buscar producto...">
            <select id="category-filter" class="form-select w-auto">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id_categoria }}">{{ $cat->nombre }}</option>
                @endforeach
            </select>
            <div class="slider-container d-flex align-items-center gap-2">
                <label for="price-filter" class="form-label mb-0">Precio máx:</label>
                <input type="range" id="price-filter" min="0" max="{{ $maxPrecio }}" step="0.01" value="{{ $maxPrecio }}">
                <span id="slider-value">{{ $maxPrecio }}</span>
                <input type="text" id="price-manual" class="form-control" placeholder="Ej: 50.00" style="width:80px;">
            </div>
        </div>

        <h3>Productos Disponibles</h3>
        <table id="available-products-table" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <h3>Venta</h3>
        <table id="sale-table" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div class="totals mt-3">
            <div class="mb-2">Total de la compra: $<span id="purchase-total">0.00</span></div>
            <div class="mb-2">
                Pago recibido: <input type="text" id="cambio-input" class="form-control d-inline-block w-auto" placeholder="0.00">
            </div>
            <div class="mb-2">Total cambio a devolver: $<span id="change-total">0.00</span></div>
        </div>
        <button class="btn btn-success mt-3" id="realizar-venta-btn">Realizar Venta</button>
        <p id="mensajeVenta" class="hidden"></p>
    </div>
</div>

{{-- Pasamos los productos a JS --}}
<script>
    window.productosDisponibles = @json($productos);
</script>

<script src="{{ asset('js/venta.js') }}"></script>
@endsection
