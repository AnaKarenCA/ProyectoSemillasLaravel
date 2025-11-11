<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Semillas y Chiles Secos')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/venta.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('styles')

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    {{-- Menú lateral dinámico --}}
    @include('partials.menu', ['menus' => app(App\Http\Controllers\MenuController::class)->obtenerMenus()])

    {{-- Contenido principal --}}
    <main class="content-wrapper" style="margin-left:0px; padding-top:0px;">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/menu.js') }}"></script>
    @stack('scripts')
</body>
</html>
<style>
    .btn-maroon {
        background-color: #800000;
        border-color: #800000;
        color: #fff;
    }

    .btn-maroon:hover {
        background-color: #a00000;
        border-color: #a00000;
        color: #fff;
    }

    .table-maroon thead {
        background-color: #800000;
        color: white;
    }

    .hero-section {
        background-color: #800000;
        color: white;
        border-radius: 6px;
        padding: 1rem;
    }

    .alert-success {
        background-color: #a64d4d;
        border-color: #800000;
        color: #fff;
    }
</style>

