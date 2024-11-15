<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso</title>
    <!-- Incluir el archivo CSS -->
    <link rel="stylesheet" href="{{ asset('css/access.css') }}">
</head>

<body>
    <h1>Acceso al GYM</h1>

    <!-- Archivos de audio para éxito y error -->
    <audio id="successSound" src="{{ asset('audio/access-granted.mp3') }}"></audio>
    <audio id="errorSound" src="{{ asset('audio/access-denied.mp3') }}"></audio>

    @if (session('message'))
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="message">{{ session('message') }}</p>
            @if (session('name') && session('lastName'))
            <p id="name">{{ session('name') }} {{ session('lastName') }}</p>
            @endif
            @if (session('expirationDate'))
            <p id="expirationDate">Fecha de vencimiento: {{ session('expirationDate') }}</p>
            @endif
        </div>
    </div>
    @endif

    <form action="{{ route('access.verify') }}" method="POST">
        @csrf
        <label for="customerID">ID:</label>
        <input type="text" id="customerID" name="customerID" required>

        <label for="key">PIN:</label>
        <input type="password" id="key" name="key" required>

        <button type="submit">Verificar</button>
    </form>

    <form action="{{ route('index') }}" method="GET">
        <button type="submit">Volver al Inicio</button>
    </form>

    <!-- Incluir el archivo JavaScript -->
    <script src="{{ asset('js/access.js') }}"></script>
</body>

</html>