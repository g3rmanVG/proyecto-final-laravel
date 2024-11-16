<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym CRUD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="icon" href="{{ asset('img/gym-logo2.png') }}" type="image/png">
</head>

<body>

    <div class="main-container">

        <div class="logo-container">
            <img src="{{ asset('img/gym-logo2.png') }}" alt="logo-image">
        </div>

        <h1>GYM CRUD</h1>

        <div class="options-container">

            <div class="access-container">
                <form action="{{ route('access') }}" method="GET">
                    <button type="submit">
                        <img src="{{ asset('img/access.png') }}" alt="logo-image">
                        Acceso
                    </button>
                </form>
            </div>

            <div>
                <button id="adminLoginBtn">
                    <img class="admin-img" src="{{ asset('img/admin.png') }}" alt="logo-image">
                    Administración
                </button>
            </div>

        </div>
    </div>

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

                <button type="submit">Ingresar</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/index.js') }}"></script>
</body>

</html>