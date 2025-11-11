@extends('layouts.app')

@section('title', 'Configuración')

@section('content')
<section class="hero-section text-center mb-4">
    <h1><span class="material-symbols-outlined">settings</span> Configuración de Usuario</h1>
</section>

<div class="container mb-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Datos del usuario actual --}}
    <div class="card mb-4 p-4">
        <h3>Mis Datos</h3>
        <form action="{{ route('configuracion.update', $usuario->id_usuario) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $usuario->nombre }}">
                </div>
                <div class="col-md-4">
                    <label>Apellido Paterno</label>
                    <input type="text" name="apellido_paterno" class="form-control" value="{{ $usuario->apellido_paterno }}">
                </div>
                <div class="col-md-4">
                    <label>Apellido Materno</label>
                    <input type="text" name="apellido_materno" class="form-control" value="{{ $usuario->apellido_materno }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label>Correo Electrónico</label>
                    <input type="email" name="correo_electronico" class="form-control" value="{{ $usuario->correo_electronico }}">
                </div>
                <div class="col-md-4">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ $usuario->direccion }}">
                </div>
                <div class="col-md-4">
                    <label>Nueva Contraseña (opcional)</label>
                    <input type="password" name="contrasena" class="form-control">
                </div>
            </div>

            <div class="mt-3">
                <label>Foto de Perfil</label>
                <input type="file" name="foto_perfil" class="form-control">
                @if($usuario->foto_perfil)
                    <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Foto" class="img-thumbnail mt-2" width="120">
                @endif
            </div>

            <button type="submit" class="btn btn-maroon mt-3">Guardar Cambios</button>
        </form>
    </div>

    {{-- Gestión de usuarios (solo admin) --}}
    @if($usuario->id_rolAsignado == 1)
    <div class="card p-4">
        <h3>Gestión de Usuarios</h3>
        <form action="{{ route('configuracion.store') }}" method="POST" class="mb-3">
            @csrf
            <div class="row">
                <div class="col-md-3"><input type="text" name="nombre" class="form-control" placeholder="Nombre" required></div>
                <div class="col-md-3"><input type="text" name="apellido_paterno" class="form-control" placeholder="Apellido Paterno" required></div>
                <div class="col-md-3"><input type="text" name="apellido_materno" class="form-control" placeholder="Apellido Materno" required></div>
                <div class="col-md-3"><input type="text" name="usuario" class="form-control" placeholder="Usuario" required></div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4"><input type="email" name="correo_electronico" class="form-control" placeholder="Correo" required></div>
                <div class="col-md-4"><input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required></div>
                <div class="col-md-4">
                    <select name="id_rolAsignado" class="form-control">
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id_rol }}">{{ $rol->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-maroon mt-3">Agregar Usuario</button>
        </form>

        <table class="table table-bordered table-maroon mt-4">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $u)
                    <tr>
                        <td>{{ $u->usuario }}</td>
                        <td>{{ $u->correo_electronico }}</td>
                        <td>{{ $u->rol->nombre ?? '-' }}</td>
                        <td>{{ $u->estado }}</td>
                        <td>
                            <form action="{{ route('configuracion.destroy', $u->id_usuario) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar usuario?')">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

<style>
.hero-section {
    background-color: #800000;
    color: white;
    padding: 1.5rem;
    width: 100%;
    border-radius: 0; /* Cuadrado */
}

.btn-maroon {
    background-color: #800000;
    border-color: #800000;
    color: #fff;
}
.btn-maroon:hover {
    background-color: #a00000;
}

.table-maroon thead {
    background-color: #800000;
    color: white;
}

.alert-success {
    background-color: #a64d4d;
    color: #fff;
}
</style>
