// resources/js/administration.js

$(document).ready(function() {
    $('#customersTable').DataTable();

    var addModal = document.getElementById("addCustomerModal");
    var editModal = document.getElementById("editCustomerModal");

    var addBtn = document.getElementById("addCustomerBtn");
    var closeAddBtn = document.getElementById("closeAddModal");

    var closeEditBtn = document.getElementById("closeEditModal");

    addBtn.onclick = function() {
        addModal.style.display = "flex";
    }

    closeAddBtn.onclick = function() {
        addModal.style.display = "none";
    }

    closeEditBtn.onclick = function() {
        editModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == addModal) {
            addModal.style.display = "none";
        } else if (event.target == editModal) {
            editModal.style.display = "none";
        }
    }

    $('.editCustomerBtn').on('click', function() {
        var customerID = $(this).data('id');
        var name = $(this).data('name');
        var lastName = $(this).data('lastname');
        var key = $(this).data('key');
        var expiration = $(this).data('expiration');

        $('#editName').val(name);
        $('#editLastName').val(lastName);
        $('#editKey').val(key);
        $('#editSubscription').val('');

        var form = $('#editCustomerForm');
        form.attr('action', '/customers/' + customerID);

        editModal.style.display = "flex";
    });

    $('#toggleAddPinVisibility').on('click', function() {
        var pinInput = $('#addKey');
        var pinButton = $(this);
        if (pinInput.attr('type') === 'password') {
            pinInput.attr('type', 'text');
            pinButton.text('Ocultar');
        } else {
            pinInput.attr('type', 'password');
            pinButton.text('Mostrar');
        }
    });

    $('#togglePinVisibility').on('click', function() {
        var pinInput = $('#editKey');
        var pinButton = $(this);
        if (pinInput.attr('type') === 'password') {
            pinInput.attr('type', 'text');
            pinButton.text('Ocultar');
        } else {
            pinInput.attr('type', 'password');
            pinButton.text('Mostrar');
        }
    });

    $('#addCustomerForm').on('submit', function(event) {
        var pinInput = $('#addKey').val();
        if (!/^\d{4}$/.test(pinInput)) {
            alert('El PIN debe tener exactamente 4 dígitos.');
            event.preventDefault();
        }
    });

    $('#editCustomerForm').on('submit', function(event) {
        var pinInput = $('#editKey').val();
        if (!/^\d{4}$/.test(pinInput)) {
            alert('El PIN debe tener exactamente 4 dígitos.');
            event.preventDefault();
        }
    });
});
