document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('messageModal');
    var span = document.getElementsByClassName('close')[0];
    var successSound = document.getElementById('successSound');
    var errorSound = document.getElementById('errorSound');
    const mensajeElement = document.getElementById("message");

    // Obtener el mensaje desde el DOM o pasar la variable desde Blade
    var message = document.getElementById('message').textContent;

    if (modal) {
        // Mostrar el modal y reproducir el sonido correspondiente
        modal.style.display = 'flex';

        // Comprobar si el mensaje es de éxito o de error
        if (message.includes("Acceso concedido")) {
            successSound.play();
            mensajeElement.style.color = "blue";
        } else if (message.includes("Suscripción vencida.")) {
            errorSound.play();
            mensajeElement.style.color = "red";
        }

        // Ocultar el modal después de 5 segundos
        setTimeout(function() {
            modal.style.display = 'none';
        }, 5000);
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
