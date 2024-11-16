// public/js/index.js

// Espera a que el DOM esté completamente cargado antes de ejecutar el código
document.addEventListener('DOMContentLoaded', function() {
    var adminLoginBtn = document.getElementById('adminLoginBtn');
    var adminLoginModal = document.getElementById('adminLoginModal');
    var closeAdminLoginModal = document.getElementById('closeAdminLoginModal');

    //  Muestra el modal de login
    adminLoginBtn.onclick = function() {
        adminLoginModal.style.display = "flex";
    }

    // Oculta el modal
    closeAdminLoginModal.onclick = function() {
        adminLoginModal.style.display = "none";
    }

    // Si el usuario hace clic fuera del modal, también se cierra el modal
    window.onclick = function(event) {
        if (event.target == adminLoginModal) {
            adminLoginModal.style.display = "none";
        }
    }
});
