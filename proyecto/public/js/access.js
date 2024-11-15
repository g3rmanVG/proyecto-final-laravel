document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('messageModal');
    var span = document.getElementsByClassName('close')[0];
    var successSound = document.getElementById('successSound');
    var errorSound = document.getElementById('errorSound');

    // Obtener el mensaje desde el DOM o pasar la variable desde Blade
    var message = document.getElementById('message').textContent;

    if (modal) {
        // Mostrar el modal y reproducir el sonido correspondiente
        modal.style.display = 'block';

        // Comprobar si el mensaje es de éxito o de error
        if (message.includes("Acceso concedido")) {
            successSound.play();
        } else if (message.includes("Acceso denegado")) {
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
