@extends('layouts.app')

@section('title', 'Agregar Cliente')

@section('content')
    <!-- Hero rojo superior -->
    <section class="hero-section text-center text-white d-flex flex-column justify-content-center align-items-center">
        <h1 class="display-6 fw-bold mt-5">Agregar Cliente</h1>
    </section>

    <div class="container mt-4">
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre*</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Correo</label>
                            <input type="email" name="correo" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="activo" selected>Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Descuento (%)</label>
                            <input type="number" step="0.01" name="descuento" class="form-control" value="0">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-guardar me-2">
                            <span class="material-icons align-middle me-1">save</span> Guardar
                        </button>
                        <a href="{{ route('clientes.index') }}" class="btn btn-cancelar">
                            <span class="material-icons align-middle me-1">cancel</span> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Importar Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        /* 🔴 Fondo general */
        body {
            background: url('{{ asset("images/home2.png") }}') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* 🔴 Hero superior */
        .hero-section {
            background-color: #800000;
            height: 180px;
            width: 100%;
            position: relative;
            top: -56px; /* Se solapa con el navbar */
            z-index: 0;
        }

        /* Contenedor principal */
        .container {
            position: relative;
            z-index: 1;
            margin-top: -30px;
        }

        /* 🧾 Tarjeta translúcida */
        .card {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 20px;
        }

        /*  Botones */
        .btn-guardar {
            background-color: #800000;
            color: #fff;
            border: none;
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        .btn-guardar:hover {
            background-color: #a00000;
            color: #fff;
            transform: scale(1.03);
        }

        .btn-cancelar {
            background-color: #6c757d;
            color: #fff;
            border: none;
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        .btn-cancelar:hover {
            background-color: #5a6268;
            color: #fff;
            transform: scale(1.03);
        }

        /* 📱 Íconos centrados */
        .material-icons {
            font-size: 20px;
            vertical-align: middle;
        }
    </style>
@endsection
