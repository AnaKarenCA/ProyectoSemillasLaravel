@extends('layouts.app')

@section('title', 'Existencias')

@section('content')
<link rel="stylesheet" href="{{ asset('css/existencias.css') }}">
<script src="{{ asset('js/existencias.js') }}"></script>

{{-- Sección encabezado ancho completo --}}
<section class="hero-existencias">
    <div class="hero-content">
        <h1>Existencias</h1>
    </div>
</section>

<div class="existencias-wrapper">
    {{-- Filtros --}}
    <div class="filters">
        <input type="text" id="searchInput" placeholder="Buscar por nombre o ID..." onkeyup="filterProducts()">
        <select id="categorySelect" onchange="filterProducts()">
            <option value="">Filtrar por categoría</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id_categoria }}">{{ $cat->nombre }}</option>
            @endforeach
        </select>
    </div>

    {{-- Notificación --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabla --}}
    <table id="productosTable" class="table table-striped table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $prod)
                <tr data-id="{{ $prod->id_producto }}" 
                    data-nombre="{{ strtolower($prod->nombre) }}" 
                    data-categoria="{{ $prod->categoria_id }}">
                    <td>{{ $prod->id_producto }}</td>
                    <td>{{ $prod->nombre }}</td>
                    <td>${{ number_format($prod->precio, 2) }}</td>
                    <td>{{ $prod->stock }}</td>
                    <td>{{ $prod->categoria->nombre ?? '' }}</td>
                    <td>
                        <a href="{{ route('existencias.edit', $prod->id_producto) }}" class="btn-edit btn btn-sm btn-primary">Editar</a>
                        
                        {{-- Botón eliminar --}}
                        <button type="button" class="btn btn-sm btn-danger" 
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmDeleteModal" 
                                data-form-id="delete-form-{{ $prod->id_producto }}">
                            Eliminar
                        </button>

                        {{-- Formulario de eliminación oculto --}}
                        <form id="delete-form-{{ $prod->id_producto }}" 
                              action="{{ route('existencias.destroy', $prod->id_producto) }}" 
                              method="POST" style="display:none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Botón agregar --}}
    <div class="actions mt-3">
        <a href="{{ route('existencias.create') }}" class="btn btn-success">Agregar Producto</a>
    </div>
</div>

{{-- Modal de confirmación --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="confirmDeleteModalLabel">Confirmar Eliminación</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Seguro que deseas eliminar este producto? Esta acción no se puede deshacer.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="modalDeleteButton">Eliminar</button>
      </div>
    </div>
  </div>
</div>

{{-- Script para manejar el modal --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    let formToSubmit = null;

    // Al abrir el modal, se captura el formulario correspondiente
    const deleteModal = document.getElementById('confirmDeleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const formId = button.getAttribute('data-form-id');
        formToSubmit = document.getElementById(formId);
    });

    // Al hacer clic en el botón "Eliminar" del modal, se envía el formulario
    const modalDeleteButton = document.getElementById('modalDeleteButton');
    modalDeleteButton.addEventListener('click', function () {
        if (formToSubmit) {
            formToSubmit.submit();
        }
    });
});
</script>

@endsection
