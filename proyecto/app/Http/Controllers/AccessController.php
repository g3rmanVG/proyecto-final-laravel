<?php
// app/Http/Controllers/AccessController.php
// Controlador de acceso que sirve para verificar la información del cliente y gestionar el acceso.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;  // Importa el modelo de cliente desde la base de datos.
use Carbon\Carbon;  // Biblioteca para manejar fechas.

// Definición de la clase AccessController que extiende el controlador base de Laravel.
class AccessController extends Controller
{
    // Método que verifica la identidad del cliente a través de su ID y clave.
    public function verify(Request $request)
    {
        // Obtiene el ID del cliente y la clave ingresada desde el formulario de solicitud.
        $customerID = $request->input('customerID');
        $key = $request->input('key');

        // Busca en la base de datos un cliente que coincida con el ID y la clave proporcionados.
        $customer = Customer::where('customerID', $customerID)
            ->where('key', $key)
            ->first();

        // Si no se encuentra el cliente, redirige al usuario con un mensaje de error.
        if (!$customer) {
            return redirect()->route('access')->with('message', 'Usuario o PIN incorrecto.');
        }

        // Obtiene la fecha actual.
        $currentDate = Carbon::now();
        // Convierte la fecha de expiración del cliente en un objeto de tipo Carbon para su comparación.
        $expirationDate = new Carbon($customer->expirationDate);

        // Compara las fechas para determinar si la suscripción ha expirado.
        $message = $currentDate->greaterThan($expirationDate)
            ? 'Suscripción vencida. Necesita renovar.'
            : 'Acceso concedido. Bienvenido.';

        // Redirige con un mensaje y datos adicionales del cliente si la verificación fue exitosa.
        return redirect()->route('access')->with([
            'message' => $message,
            'name' => $customer->name,
            'lastName' => $customer->lastName,
            'expirationDate' => $expirationDate->toDateString()
        ]);
    }
}
