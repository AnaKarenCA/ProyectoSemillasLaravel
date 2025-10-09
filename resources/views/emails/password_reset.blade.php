<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recuperación de Contraseña</title>
</head>
<body>
    <h2>Hola {{ $user->usuario }},</h2>
    <p>Tu nueva contraseña temporal es:</p>
    <h3>{{ $newPassword }}</h3>
    <p>Por seguridad, te recomendamos cambiarla al iniciar sesión.</p>
    <p>Saludos,<br>Equipo de Soporte</p>
</body>
</html>
