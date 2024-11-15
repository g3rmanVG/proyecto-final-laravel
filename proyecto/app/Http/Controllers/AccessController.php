<?php
// app/Http/Controllers/AccessController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Carbon\Carbon;

class AccessController extends Controller
{
    public function verify(Request $request)
    {
        $customerID = $request->input('customerID');
        $key = $request->input('key');
        $customer = Customer::where('customerID', $customerID)
            ->where('key', $key)
            ->first();

        if (!$customer) {
            return redirect()->route('access')->with('message', 'Usuario o PIN incorrecto.');
        }

        $currentDate = Carbon::now();
        $expirationDate = new Carbon($customer->expirationDate);

        $message = $currentDate->greaterThan($expirationDate)
            ? 'Suscripción vencida. Necesita renovar.'
            : 'Acceso concedido. Bienvenido.';

        return redirect()->route('access')->with([
            'message' => $message,
            'name' => $customer->name,
            'lastName' => $customer->lastName,
            'expirationDate' => $expirationDate->toDateString()
        ]);
    }
}
