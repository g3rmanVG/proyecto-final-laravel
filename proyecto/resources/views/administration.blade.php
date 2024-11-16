<!-- resources/views/administration.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link href="{{ asset('css/administration.css') }}" rel="stylesheet">
    <!-- Incluyendo DataTables -->
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Incluyendo jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Incluyendo DataTables -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="icon" href="{{ asset('img/admin.png') }}" type="image/png">

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
                    <input type="password" id="addKey" name="key" required pattern="\d{4}" title="Debe tener exactamente 4 dígitos">
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
                    <input type="password" id="editKey" name="key">
                    <button type="button" id="togglePinVisibility" style="margin-left: 5px;">Mostrar</button>
                </div>

                <label for="editSubscription">Suscripción:</label>
                <select id="editSubscription" name="subscription">
                    <option value="week">Semana</option>
                    <option value="month">Mes</option>
                    <option value="year">Año</option>
                </select>

                <button class="submitEdit" type="submit">Actualizar</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/administration.js') }}"></script>
</body>

</html>