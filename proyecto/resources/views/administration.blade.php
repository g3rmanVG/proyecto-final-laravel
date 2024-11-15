<!-- resources/views/administration.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Incluyendo jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Incluyendo DataTables -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
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
    <h1>Bienvenido a la Administración</h1>

    <form action="{{ route('index') }}" method="GET">
        <button type="submit">Volver al Inicio</button>
    </form>

    <h2>Clientes</h2>
    <button id="addCustomerBtn">Agregar Cliente</button>

    <table id="customersTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Fecha de Vencimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->customerID }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->lastName }}</td>
                <td>{{ $customer->expirationDate }}</td>
                <td>
                    <button class="editCustomerBtn" data-id="{{ $customer->customerID }}" data-name="{{ $customer->name }}" data-lastname="{{ $customer->lastName }}" data-key="{{ $customer->key }}" data-expiration="{{ $customer->expirationDate }}">Editar</button>
                    <form action="{{ route('customers.destroy', $customer->customerID) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?');">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal para Agregar Cliente -->
    <div id="addCustomerModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeAddModal">&times;</span>
            <h2>Agregar Cliente</h2>
            <form id="addCustomerForm" method="POST" action="{{ route('customers.store') }}">
                @csrf

                <label for="addName">Nombre:</label>
                <input type="text" id="addName" name="name" required>

                <label for="addLastName">Apellido:</label>
                <input type="text" id="addLastName" name="lastName" required>

                <label for="addKey">Clave (PIN de 4 dígitos):</label>
                <div style="display: flex; align-items: center;">
                    <input type="password" id="addKey" name="key" required pattern="\d{4}" title="Debe tener exactamente 4 dígitos" style="flex: 1;">
                    <button type="button" id="toggleAddPinVisibility" style="margin-left: 5px;">Mostrar</button>
                </div>

                <label for="addSubscription">Suscripción:</label>
                <select id="addSubscription" name="subscription" required>
                    <option value="week">Semana</option>
                    <option value="month">Mes</option>
                    <option value="year">Año</option>
                </select>

                <button type="submit">Agregar</button>
            </form>
        </div>
    </div>


    <!-- Modal para Editar Cliente -->
    <div id="editCustomerModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditModal">&times;</span>
            <h2>Editar Cliente</h2>
            <form id="editCustomerForm" method="POST">
                @csrf
                @method('PUT')

                <label for="editName">Nombre:</label>
                <input type="text" id="editName" name="name" required>

                <label for="editLastName">Apellido:</label>
                <input type="text" id="editLastName" name="lastName" required>

                <label for="editKey">Clave (PIN de 4 dígitos):</label>
                <div style="display: flex; align-items: center;">
                    <input type="password" id="editKey" name="key" required style="flex: 1;">
                    <button type="button" id="togglePinVisibility" style="margin-left: 5px;">Mostrar</button>
                </div>

                <label for="editSubscription">Suscripción:</label>
                <select id="editSubscription" name="subscription">
                    <option value="week">Semana</option>
                    <option value="month">Mes</option>
                    <option value="year">Año</option>
                </select>

                <button type="submit">Actualizar</button>
            </form>
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $('#customersTable').DataTable();

            var addModal = document.getElementById("addCustomerModal");
            var editModal = document.getElementById("editCustomerModal");

            var addBtn = document.getElementById("addCustomerBtn");
            var closeAddBtn = document.getElementById("closeAddModal");

            var closeEditBtn = document.getElementById("closeEditModal");

            addBtn.onclick = function() {
                addModal.style.display = "block";
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

                editModal.style.display = "block";
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
    </script>

</body>

</html>