<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Semillas y Chiles Secos - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        body {
            background: url('{{ asset("images/home2.png") }}') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section { position: relative; text-align: center; color: #fff; }
        .hero-section::before {
            content: ""; position: absolute; top:0; left:0; width:100%; height:100%;
            background: #800000; z-index: -1;
        }
        .card { backdrop-filter: blur(6px); background-color:  #80000091; border: none; color:#fff; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,0,0,0.2); }
        .list-group-item:hover { background-color: rgba(255,182,188,0.93); }
        .badge { font-size: 1.1rem; }
        
        /* Estilo para los nuevos íconos y texto */
        .sales-icon { font-size: 50px; color: black; }
        .sales-link p { color: black !important; font-weight: 600; }
    </style>
</head>
<body>
    <section class="hero-section py-4">
        <h1>Bienvenido al sitio Semillas y Chiles Secos</h1>
        <p class="lead">Hola, {{ $usuario->nombre }}</p>

        
    </section>
@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <main class="container mb-5">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card p-4 h-100 text-center">
                    <h2 class="h4 mb-3">Resumen Ejecutivo</h2>
                    <p class="mb-1"><strong>Ventas del Día:</strong> {{ $resumen->ventas_dia }}</p>
                    <p class="mb-0"><strong>Total Ingresos:</strong> ${{ number_format($resumen->total_ingresos,2) }}</p>
                </div>
            </div>

            
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card p-4">
                    <h2 class="h4 text-center mb-3">Productos con Bajo Stock</h2>
                    <div class="card-body">
                        @if($productosBajoStock->isNotEmpty())
                            <ul class="list-group">
                                @foreach($productosBajoStock as $producto)
                                    <li class="list-group-item d-flex flex-column align-items-center">
                                        <span>{{ $producto->nombre }}</span>
                                        <span class="badge bg-danger rounded-pill mt-2">{{ $producto->stock }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-center mb-0">No hay productos con bajo stock.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>