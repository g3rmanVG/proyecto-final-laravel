<?php

// routes/web.php

// Importamos los controladores.
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\CustomerController;

// Ruta principal de la aplicación, que carga la vista de la página de inicio.
Route::get('/', function () {
    return view('index');
})->name('index');

// Ruta de la página de acceso, que carga la vista del formulario de acceso.
Route::get('/access', function () {
    return view('access');
})->name('access');

// Ruta para procesar la verificación de acceso de clientes.
// Utiliza el método 'verify' del controlador AccessController.
Route::post('/access-verify', [AccessController::class, 'verify'])->name('access.verify');

// Ruta para autenticar a los administradores.
// Utiliza el método 'authenticate' del controlador AdminController.
Route::post('/admin-authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');

// Ruta para acceder a la vista de administración, que muestra la lista de clientes.
// Requiere que el usuario esté autenticado como administrador.
Route::get('/administration', function () {
    if (!session('is_admin')) {
        return redirect()->route('admin.login'); // Redirige si no está autenticado.
    }
    $customers = \App\Models\Customer::all(); // Obtiene todos los clientes.
    return view('administration', compact('customers')); // Carga la vista con los clientes.
})->name('administration');

// Rutas RESTful para el recurso 'customers', manejadas por CustomerController.
Route::resource('customers', CustomerController::class);
