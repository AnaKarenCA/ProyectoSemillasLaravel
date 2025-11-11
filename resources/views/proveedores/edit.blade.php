@extends('layouts.app')
@section('title', 'Editar Proveedor')

@section('content')
<div class="container mt-4">
    <h2>Editar Proveedor</h2>
    <form action="{{ route('proveedores.update', $proveedor->id_proveedor) }}" method="POST">
        @include('proveedores.form')
    </form>
</div>
@endsection
