@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <!-- 🟥 Hero superior -->
    <section class="hero-section text-center text-white d-flex flex-column justify-content-center align-items-center">
        <h1 class="display-5 fw-bold">Clientes registrados</h1>
    </section>

    <div class="container mt-5 mb-5">
        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <!-- Botón principal -->
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('clientes.create') }}" class="btn btn-nuevo">
                <span class="material-icons align-middle me-1">person_add</span> Nuevo Cliente
            </a>
        </div>

        <div class="card shadow-lg border-0">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>Descuento (%)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $cliente)
                            <tr class="{{ $cliente->estado === 'inactivo' ? 'table-secondary' : '' }}">
                                <td>{{ $cliente->id_cliente }}</td>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->telefono ?? '—' }}</td>
                                <td>{{ $cliente->correo ?? '—' }}</td>
                                <td>{{ $cliente->direccion ?? '—' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $cliente->estado == 'activo' ? 'success' : 'danger' }}">
                                        {{ ucfirst($cliente->estado) }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $cliente->descuento }}%</td>
                                <td class="text-center">
                                    <a href="{{ route('clientes.edit', $cliente->id_cliente) }}" 
                                       class="btn btn-editar btn-sm me-1" title="Editar">
                                        <span class="material-icons align-middle">edit</span>
                                    </a>

                                    <form action="{{ route('clientes.destroy', $cliente->id_cliente) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-eliminar btn-sm" 
                                                onclick="return confirm('¿Eliminar cliente?')" title="Eliminar">
                                            <span class="material-icons align-middle">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">No hay clientes registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        /* 🔴 Fondo general */
        body {
            background: url('{{ asset("images/home2.png") }}') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* 🟥 Hero superior */
        .hero-section {
            background-color: #800000;
            height: 120px;
            width: 100%;
            position: relative;
            top: 0;
            
            z-index: 1;
        }

        /* 📦 Contenedor */
        .container {
            position: relative;
            z-index: 2;
        }

        /* 🧾 Tarjeta translúcida */
        .card {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
        }

        /* 🧱 Tabla */
        thead th {
            background-color: #800000 !important;
            color: #fff !important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 182, 188, 0.3);
        }

        /* 🎨 Botones */
        .btn-nuevo {
            background-color: #ce0202c3;
            color: #fff;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }
        .btn-nuevo:hover {
            background-color: #800404ff;
            color: #fff;
            transform: scale(1.03);
        }

        .btn-editar {
            background-color: #8db848ff;
            color: #000;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-editar:hover {
            background-color: #1f6826ff;
            color: #fff;
            transform: scale(1.05);
        }

        .btn-eliminar {
            background-color: #ea2a3dff;
            color: #fff;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-eliminar:hover {
            background-color: #86202aff;
            color: #fff;
            transform: scale(1.05);
        }

        .material-icons {
            font-size: 20px;
            vertical-align: middle;
        }

        /* 📱 Responsividad */
        @media (max-width: 992px) {
            .hero-section {
                height: 140px;
                
            }
            table {
                font-size: 0.9rem;
            }
            .btn {
                font-size: 0.85rem;
                padding: 4px 8px;
            }
        }

        @media (max-width: 768px) {
            .table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            .btn-nuevo {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection
