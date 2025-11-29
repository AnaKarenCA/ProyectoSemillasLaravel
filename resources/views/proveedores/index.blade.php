@extends('layouts.app')

@section('title', 'Catálogo de productos')

@section('content')

<style>
    .hero-existencias { width:100%; background-color:#800000; padding:20px 0; text-align:center; color:white; margin-bottom:20px; }
    .btn-main { background-color:#800000; color:white; border:none; }
    .btn-main:hover { background-color:#a00000; }
    .stock-ok { color:green; font-weight:bold; }
    .stock-warning { color:orange; font-weight:bold; }
    .stock-zero { color:red; font-weight:bold; }
    img.product-img { width:50px; height:50px; object-fit:cover; border-radius:5px; }
</style>

<section class="hero-existencias">
    <h1>Catálogo de productos</h1>
</section>

<div class="container">
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre o código..." onkeyup="filterProducts()">
        </div>

        <div class="col-md-3">
            <select id="categorySelect" class="form-control" onchange="filterProducts()">
                <option value="">Filtrar por categoría</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id_categoria }}">{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select id="stockFilter" class="form-control" onchange="filterProducts()">
                <option value="">Stock</option>
                <option value="ok">Disponible</option>
                <option value="low">Bajo stock</option>
                <option value="zero">Agotado</option>
                <option value="inactive">Descontinuado</option>
            </select>
        </div>

        <div class="col-md-3">
            <a href="{{ route('existencias.create') }}" class="btn btn-main w-100">+ Agregar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table id="productosTable" class="table table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Img</th>
                <th>Producto</th>
                <th>Código</th>
                <th>Unidad</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $prod)
            @php
                $estadoStock = $prod->stock == 0 ? 'zero' : ($prod->stock <= $prod->stock_min ? 'low' : 'ok');
            @endphp
            <tr data-category="{{ $prod->categoria_id }}" data-stock="{{ $prod->estado == 'activo' ? $estadoStock : 'inactive' }}" data-name="{{ strtolower($prod->nombre.' '.$prod->codigo_barras) }}">
                <td><img src="{{ $prod->imagenes ? asset('storage/'.$prod->imagenes) : asset('img/noimage.png') }}" class="product-img"></td>
                <td>{{ $prod->nombre }}</td>
                <td>{{ $prod->codigo_barras ?? '—' }}</td>
                <td>{{ $prod->unidad_venta }}</td>
                <td>${{ number_format($prod->precio, 2) }}</td>
                <td>
                    <span class="{{ $estadoStock == 'zero' ? 'stock-zero' : ($estadoStock == 'low' ? 'stock-warning' : 'stock-ok') }}">
                        {{ $prod->stock }}
                    </span>
                </td>
                <td>{{ $prod->categoria->nombre ?? '—' }}</td>
                <td>
                    <a href="{{ route('existencias.edit', $prod->id_producto) }}" class="btn btn-sm btn-main">Editar</a>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-form-id="delete-{{ $prod->id_producto }}">Eliminar</button>
                    <form id="delete-{{ $prod->id_producto }}" method="POST" action="{{ route('existencias.destroy', $prod->id_producto) }}">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal eliminar --}}
<div class="modal fade" id="confirmDeleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>¿Eliminar producto?</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">Esta acción no se puede revertir.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-danger" id="modalDeleteButton">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
let formToSubmit = null;
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('confirmDeleteModal');
    modal.addEventListener('show.bs.modal', (e) => {
        formToSubmit = document.getElementById(e.relatedTarget.getAttribute('data-form-id'));
    });
    document.getElementById('modalDeleteButton').addEventListener('click', () => formToSubmit.submit());
});

function filterProducts() {
    let text = document.getElementById("searchInput").value.toLowerCase();
    let category = document.getElementById("categorySelect").value;
    let stock = document.getElementById("stockFilter").value;

    document.querySelectorAll("#productosTable tbody tr").forEach(row => {
        let name = row.dataset.name;
        let rowCategory = row.dataset.category;
        let rowStock = row.dataset.stock;

        row.style.display = (name.includes(text) &&
            (!category || category === rowCategory) &&
            (!stock || stock === rowStock)) ? "" : "none";
    });
}
</script>

@endsection
