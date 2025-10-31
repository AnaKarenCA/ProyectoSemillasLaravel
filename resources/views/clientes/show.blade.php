@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Cliente</h1>

    <ul class="list-group">
        <li class="list-group-item"><strong>Nombre:</strong> {{ $cliente->nombre }} {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}</li>
        <li class="list-group-item"><strong>Correo:</strong> {{ $cliente->correo_electronico }}</li>
        <li class="list-group-item"><strong>Teléfono:</strong> {{ $cliente->telefono }}</li>
        <li class="list-group-item"><strong>Dirección:</strong> {{ $cliente->direccion }}</li>
        <li class="list-group-item"><strong>Estado:</strong> {{ ucfirst($cliente->estado) }}</li>
    </ul>

    <a href="{{ route('clientes.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
