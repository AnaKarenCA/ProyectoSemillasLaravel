<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semillas y Chiles Secos</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <header>
        <h1 class="neon-title">Semillas y Chiles Secos</h1>
    </header>

    <div class="container">
        <div class="tabs">
            <button id="loginTab" class="tab active">Iniciar sesión</button>
            <button id="recoverTab" class="tab">Recuperar contraseña</button>
        </div>

        <div class="card-wrapper">
            <!-- LOGIN -->
            <div class="card active" id="loginCard">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h2>Iniciar sesión</h2>
                    <label for="username">Nombre de usuario</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
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
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                        });
                    </script>
                @endif
            </div>

            <!-- RECUPERAR CONTRASEÑA -->
            <div class="card" id="recoverCard">
                <form method="POST" action="{{ route('recuperar') }}" id="recoverForm">
                    @csrf
                    <h2>Recuperar contraseña</h2>
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="correo_electronico" required>
                    <button type="submit">Recuperar</button>
                </form>

                @if(session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: "{{ session('success') }}",
                                timer: 5000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                        });
                    </script>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('js/index.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginTab = document.getElementById('loginTab');
            const recoverTab = document.getElementById('recoverTab');
            const loginCard = document.getElementById('loginCard');
            const recoverCard = document.getElementById('recoverCard');
            const usernameInput = document.getElementById('username');

            // Funcionalidad de las pestañas
            loginTab.addEventListener('click', () => {
                loginTab.classList.add('active');
                recoverTab.classList.remove('active');
                loginCard.classList.add('active');
                recoverCard.classList.remove('active');
            });

            recoverTab.addEventListener('click', () => {
                recoverTab.classList.add('active');
                loginTab.classList.remove('active');
                recoverCard.classList.add('active');
                loginCard.classList.remove('active');
            });

            // Validación del campo "Nombre de usuario"
            usernameInput.addEventListener('blur', () => {
                const usernameValue = usernameInput.value;
                if (/\d/.test(usernameValue)) {
                    Swal.fire('Error', 'No se permiten números en el nombre de usuario.', 'error');
                    usernameInput.value = '';
                }
            });

            // Manejo de la recuperación de contraseña
            document.getElementById('recoverForm').addEventListener('submit', function(event) {
                event.preventDefault();
                let email = document.getElementById('email').value;
                if (!email) {
                    Swal.fire('Error', '⚠️ Ingresa tu correo.', 'error');
                    return;
                }
                fetch("{{ route('recuperar') }}", {
                    method: 'POST',
                    body: new URLSearchParams({ correo_electronico: email }),
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: data.status === "success" ? 'success' : 'error',
                        title: data.status === "success" ? 'Éxito' : 'Error',
                        text: data.message
                    });
                })
                .catch(error => {
                    console.error("Error:", error);
                });
            });
        });
    </script>
</body>
</html>
<style>
/* --- GENERAL --- */
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: linear-gradient(135deg, #FFF7EB, #FFD7A0);
    color: #040317;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column; /* Para tener header arriba y container centrado */
    align-items: center;
}

/* --- HEADER --- */
header {
    width: 100%;
    text-align: center;
    margin: 40px 0 20px 0;
}

.header-title {
    font-size: 3em;
    color: #9f0606;
    font-weight: bold;
    text-shadow:
        1px 1px 0 #7a0404,
        2px 2px 0 #5a0303;
}

/* --- CONTAINER (TARJETA) --- */
.container {
    width: 90%;
    max-width: 450px;
    background: #FFF7EB;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s;
    margin-bottom: 40px; /* separación con el footer o borde inferior */
}

.container:hover {
    transform: translateY(-5px);
}

/* --- TABS --- */
.tabs {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
    width: 100%;
}

.tab {
    flex: 1;
    padding: 12px 0;
    border: none;
    cursor: pointer;
    background: #E3CFA6;
    color: #9f0606;
    font-weight: 600;
    border-radius: 10px 10px 0 0;
    transition: background 0.3s, color 0.3s;
    text-align: center;
}

.tab.active {
    background: #9f0606;
    color: #FFF7EB;
}

/* --- CARD WRAPPER --- */
.card-wrapper {
    width: 100%;
    position: relative;
}

.card {
    display: none;
    background: #FFF7EB;
    padding: 25px 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    transition: opacity 0.4s ease, transform 0.4s ease;
}

.card.active {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

/* --- FORM ELEMENTS --- */
input, select, button {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border: 1px solid #ADADAD;
    border-radius: 8px;
    font-size: 1em;
    outline: none;
    transition: border-color 0.3s, box-shadow 0.3s;
}

input:focus {
    border-color: #9f0606;
    box-shadow: 0 0 8px rgba(159,6,6,0.5);
}

button {
    background-color: #9f0606;
    color: #FFF7EB;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s, transform 0.2s;
}

button:hover {
    background-color: #7a0404;
    transform: scale(1.02);
}

/* --- TABLES --- */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

table, th, td {
    border: 1px solid #9f0606;
}

th, td {
    padding: 10px;
    text-align: center;
}

/* --- DROPDOWN --- */
.dropdown {
    list-style: none;
    padding: 0;
    margin: 0;
    position: absolute;
    background-color: white;
    border: 1px solid #ccc;
    max-height: 150px;
    overflow-y: auto;
    width: 100%;
    z-index: 10;
    border-radius: 5px;
    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
}

.dropdown li {
    padding: 10px;
    cursor: pointer;
    transition: background 0.2s;
}

.dropdown li:hover {
    background-color: #f0e6e6;
}

/* --- RESPONSIVE --- */
@media (max-width: 500px) {
    .container {
        padding: 20px;
    }

    .header-title {
        font-size: 2em;
    }

    input, button {
        padding: 10px;
    }
}


    
</style>