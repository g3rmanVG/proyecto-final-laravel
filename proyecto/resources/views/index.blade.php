<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym CRUD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
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

    <script src="{{ asset('js/index.js') }}"></script>
</body>

</html>