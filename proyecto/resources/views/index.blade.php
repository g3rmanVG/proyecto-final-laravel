<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym CRUD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Estilos para los modales */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Hola flaco, bienvenido al GYM</h1>

    <form action="{{ route('access') }}" method="GET">
        <button type="submit">Acceso</button>
    </form>

    <button id="adminLoginBtn">Administración</button>

    <!-- Modal para Login de Administrador -->
    <div id="adminLoginModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeAdminLoginModal">&times;</span>
            <h2>Login de Administrador</h2>
            <form action="{{ route('admin.authenticate') }}" method="POST">
                @csrf
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript para manejar la visibilidad del modal
        document.addEventListener('DOMContentLoaded', function() {
            var adminLoginBtn = document.getElementById('adminLoginBtn');
            var adminLoginModal = document.getElementById('adminLoginModal');
            var closeAdminLoginModal = document.getElementById('closeAdminLoginModal');

            adminLoginBtn.onclick = function() {
                adminLoginModal.style.display = "block";
            }

            closeAdminLoginModal.onclick = function() {
                adminLoginModal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == adminLoginModal) {
                    adminLoginModal.style.display = "none";
                }
            }
        });
    </script>
</body>

</html>