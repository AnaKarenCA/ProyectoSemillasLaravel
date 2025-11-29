@extends('layouts.app')
@section('title', 'Registro de Venta')

@section('content')
<h2>Registro de Venta</h2>

{{-- ==================== FILTROS ==================== --}}
<div class="card mb-3 p-3">
    <h5>Filtros de búsqueda</h5>

    <div class="row">
        <div class="col-md-3">
            <label>Código</label>
            <input type="text" id="filtro_codigo" class="form-control" placeholder="Código...">
        </div>

        <div class="col-md-3">
            <label>Nombre</label>
            <input type="text" id="filtro_nombre" class="form-control" placeholder="Nombre del producto...">
        </div>

        <div class="col-md-3">
            <label>Precio mínimo</label>
            <input type="number" id="filtro_precio_min" class="form-control" min="0">
        </div>

        <div class="col-md-3">
            <label>Precio máximo</label>
            <input type="number" id="filtro_precio_max" class="form-control" min="0">
        </div>
    </div>
</div>

{{-- ==================== TABLA DE PRODUCTOS ==================== --}}
<h4>Productos Disponibles</h4>

<table class="table table-bordered" id="tablaProductos">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody id="productosBody">

        @foreach($productos as $prod)
        <tr class="producto_row"
            data-nombre="{{ strtolower($prod->nombre) }}"
            data-codigo="{{ strtolower($prod->codigo ?? $prod->codigo_barras ?? '') }}"
            data-precio="{{ $prod->precio }}">

            <td>{{ $prod->nombre }}</td>
            <td>${{ number_format($prod->precio, 2) }}</td>
            <td>{{ number_format($prod->stock, 3) }}</td>
            <td>
                @if($prod->stock > 0)
                <button class="btn btn-primary agregarProducto"
                    data-id="{{ $prod->id_producto }}"
                    data-nombre="{{ $prod->nombre }}"
                    data-precio="{{ $prod->precio }}">
                    Agregar
                </button>
                @else
                <button class="btn btn-secondary" disabled>Sin stock</button>
                @endif
            </td>
        </tr>
        @endforeach

    </tbody>
</table>

{{-- ==================== CARRITO ==================== --}}
<h4>Carrito</h4>

<table class="table table-striped" id="tablaCarrito">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cant.</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody id="carritoBody"></tbody>
</table>

<h3>Total: $<span id="totalVenta">0.00</span></h3>

<button class="btn btn-success" id="btnGuardarVenta">Guardar Venta</button>

<script src="{{ asset('js/ventas.js') }}"></script>

@endsection
