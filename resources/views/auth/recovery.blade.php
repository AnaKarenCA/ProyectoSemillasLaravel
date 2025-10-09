@extends('layouts.app')

@section('content')
<div style="max-width:400px;margin:50px auto;">
    <h2 style="text-align:center;color:#800000;">Recuperar Contraseña</h2>

    @if (session('success'))
        <div style="background:#d4edda;color:#155724;padding:10px;margin-bottom:10px;border-radius:5px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background:#f8d7da;color:#721c24;padding:10px;margin-bottom:10px;border-radius:5px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.recovery.send') }}">
        @csrf
        <label>Correo electrónico:</label>
        <input type="email" name="correo_electronico" required class="form-control"
               style="width:100%;padding:8px;margin-bottom:10px;">

        <button type="submit" style="width:100%;background:#800000;color:#fff;padding:8px;border:none;border-radius:5px;">
            Enviar contraseña temporal
        </button>
    </form>
</div>
@endsection
