<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso</title>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('messageModal');
            var span = document.getElementsByClassName('close')[0];
            var successSound = document.getElementById('successSound');
            var errorSound = document.getElementById('errorSound');

            if (modal) {
                // Mostrar el modal y reproducir el sonido correspondiente
                modal.style.display = 'block';

                // Comprobar si el mensaje es de éxito o de error (esto depende del contenido de session('message'))
                var message = "{{ session('message') }}";
                if (message.includes("Acceso concedido")) {
                    successSound.play();
                } else {
                    errorSound.play();
                }

                // Ocultar el modal después de 7 segundos
                setTimeout(function() {
                    modal.style.display = 'none';
                }, 7000);
            }

            // Cerrar el modal cuando se hace clic en la "x"
            span.onclick = function() {
                modal.style.display = 'none';
            }

            // Cerrar el modal cuando se hace clic fuera de él
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        });
    </script>
</body>

</html>