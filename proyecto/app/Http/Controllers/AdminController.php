<?php
// app/Http/Controllers/AdminController.php
// Controlador de administración que gestiona la autenticación de administradores al CRUD.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administration;  // Importa el modelo de administración.

class AdminController extends Controller
{
    // Método que autentica a un administrador a través de sus credenciales.
    public function authenticate(Request $request)
    {
        // Obtiene solo el 'username' y 'password' de la solicitud.
        $credentials = $request->only('username', 'password');

        // Busca en la base de datos un registro de administrador que coincida con el nombre de usuario y la contraseña.
        $admin = Administration::where('username', $credentials['username'])
            ->where('password', $credentials['password'])
            ->first();

        // Si se encuentra un administrador, las credenciales son correctas.
        if ($admin) {
            // Guarda un valor en la sesión para indicar que el usuario es un administrador autenticado.
            session(['is_admin' => true]);
            // Redirige a la página de administración.
            return redirect()->route('administration');
        } else {
            // Si las credenciales son incorrectas, redirige de vuelta con un mensaje de error.
            return redirect()->back()->withErrors('Credenciales incorrectas')->withInput();
        }
    }
}
