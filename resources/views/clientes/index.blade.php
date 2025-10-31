@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <section class="hero-section py-5 mb-4 text-center text-white">
        <h1 class="display-5 fw-bold">Lista de Clientes</h1>
        <p class="lead">Consulta, administra y edita la información de tus clientes registrados</p>
    </section>

    <div class="container mb-5">
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Dirección</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $c)
                            <tr>
                                <td>{{ $c->id_cliente }}</td>
                                <td>{{ $c->nombre }}</td>
                                <td>{{ $c->telefono }}</td>
                                <td>{{ $c->correo }}</td>
                                <td>{{ $c->direccion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* 🔴 Fondo tipo Home */
        body {
            background: url('{{ asset("images/home2.png") }}') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* 🔴 Hero rojo que abarca todo el ancho */
        .hero-section {
            position: relative;
            background-color: #800000;
            width: 100%;
            color: #fff;
            margin-top: -24px; /* compensa el espacio del navbar */
        }

        /* Sombras y bordes suaves */
        .card {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
        }

        table {
            background-color: white;
        }

        thead th {
            background-color: #800000 !important;
            color: #fff !important;
        }

        .table-striped > tbody > tr:nth-of-type(odd) {
            background-color: #f8f8f8;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 182, 188, 0.3);
        }
    </style>
@endsection
