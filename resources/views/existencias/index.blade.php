@extends('layouts.app')

@section('title', 'Catálogo de productos')

@section('content')

<style>
    .hero-existencias {
        width: 100%;
        background-color: #800000;
        padding: 20px 0;
        text-align: center;
        color: white;
        margin-bottom: 20px;
        font-size: 26px;
        font-weight: bold;
    }

    .btn-main {
        background-color: #800000;
        color: white;
        border: none;
    }

    .btn-main:hover {
        background-color: #a00000;
        color: white;
    }

    .stock-ok { color: green; font-weight: bold; }
    .stock-low { color: orange; font-weight: bold; }
    .stock-zero { color: red; font-weight: bold; }

    .product-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
    }

    .prod-inactivo {
        opacity: 0.45;
    }
</style>

<section class="hero-existencias">
    Catálogo de productos
</section>

<div class="container">

    {{-- FILTROS --}}
    <div class="row mb-3">

        <div class="col-md-3">
            <input type="text" id="searchInput" class="form-control"
                placeholder="Buscar por nombre o código..."
                onkeyup="filterProducts()">
        </div>

        <div class="col-md-2">
            <select id="categorySelect" class="form-control" onchange="filterProducts()">
                <option value="">Categoría</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id_categoria }}">{{ $cat->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select id="stockFilter" class="form-control" onchange="filterProducts()">
                <option value="">Stock</option>
                <option value="ok">Disponible</option>
                <option value="low">Bajo stock</option>
                <option value="zero">Agotado</option>
            </select>
        </div>

        <div class="col-md-2">
            <select id="estadoFilter" class="form-control" onchange="filterProducts()">
                <option value="">Estado</option>
                <option value="1">Activos</option>
                <option value="0">Inactivos</option>
            </select>
        </div>

        <div class="col-md-3">
            <a href="{{ route('existencias.create') }}" class="btn btn-main w-100">
                + Agregar producto
            </a>
        </div>
    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- TABLA PRODUCTOS --}}
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
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($productos as $prod)

            @php
                $estadoStock =
                    $prod->stock == 0 ? 'zero'
                    : ($prod->stock <= $prod->stock_min ? 'low' : 'ok');
            @endphp

            <tr 
                class="{{ $prod->activo ? '' : 'prod-inactivo' }}"
                data-name="{{ strtolower($prod->nombre) }}"
                data-code="{{ strtolower($prod->codigo ?? $prod->codigo_barras ?? '') }}"
                data-category="{{ $prod->categoria_id }}"
                data-stock="{{ $estadoStock }}"
                data-activo="{{ $prod->activo }}"
            >

                {{-- Imagen --}}
                <td>
                    <img src="{{ $prod->imagenes ? asset('storage/'.$prod->imagenes) : asset('img/noimage.png') }}"
                        class="product-img" alt="{{ $prod->nombre }}">
                </td>

                <td>{{ $prod->nombre }}</td>

                {{-- Código --}}
                <td>{{ $prod->codigo ?? $prod->codigo_barras ?? '—' }}</td>

                <td>{{ $prod->unidad_venta ?? '—' }}</td>

                <td>${{ number_format($prod->precio, 2) }}</td>

                <td>
                    <span class="
                        {{ $estadoStock=='zero' ? 'stock-zero' : 
                           ($estadoStock=='low' ? 'stock-low' : 'stock-ok') }}">
                        {{ $prod->stock }}
                    </span>
                </td>

                <td>{{ $prod->categoria->nombre ?? '—' }}</td>

                <td>
                    @if($prod->activo)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </td>

                <td class="text-center">
                    <a href="{{ route('existencias.edit', $prod->id_producto) }}"
                        class="btn btn-sm btn-main mb-1">Editar</a>

                    @if($prod->activo)
                        <form method="POST"
                              action="{{ route('existencias.desactivar', $prod->id_producto) }}">
                            @csrf
                            <button class="btn btn-warning btn-sm w-100 mt-1">Desactivar</button>
                        </form>
                    @else
                        <form method="POST"
                            action="{{ route('existencias.activar', $prod->id_producto) }}"
                            onsubmit="return confirmarActivar()">
                            @csrf
                            <button class="btn btn-success btn-sm w-100 mt-1">Activar</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
function filterProducts() {
    let text = document.getElementById("searchInput").value.toLowerCase();
    let category = document.getElementById("categorySelect").value;
    let stock = document.getElementById("stockFilter").value;
    let estado = document.getElementById("estadoFilter").value;

    document.querySelectorAll("#productosTable tbody tr").forEach(row => {
        let name = row.dataset.name;
        let code = row.dataset.code;
        let cat = row.dataset.category;
        let stk = row.dataset.stock;
        let active = row.dataset.activo;

        let match =
            (name.includes(text) || code.includes(text)) &&
            (!category || category === cat) &&
            (!stock || (stock === stk && active == 1)) &&
            (!estado || estado === active);

        row.style.display = match ? "" : "none";
    });
}

function confirmarActivar() {
    return confirm("¿Estás seguro de volver a ACTIVAR este producto?");
}
</script>

@endsection
