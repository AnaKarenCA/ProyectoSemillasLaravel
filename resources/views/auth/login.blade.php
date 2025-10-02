<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <header>
      <h1 class="neon-title">Semillas y Chiles Secos</h1>
    </header>
  <div class="container">
      <div class="card-wrapper">
          <form method="POST" action="{{ url('/login') }}">
              @csrf
              <h2>Iniciar sesión</h2>
              <label for="username">Usuario</label>
              <input type="text" name="username" required>
              <label for="password">Contraseña</label>
              <input type="password" name="password" required>
              <button type="submit">Iniciar sesión</button>
          </form>

          @if ($errors->any())
              <script>
                  document.addEventListener('DOMContentLoaded', function() {
                      Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: "{{ $errors->first() }}",
                        timer: 5000,
                        showConfirmButton: false
                      });
                  });
              </script>
          @endif
      </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
