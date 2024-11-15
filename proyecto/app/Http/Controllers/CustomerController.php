<?php
// app/Http/Controllers/CustomerController.php
// Controlador que gestiona las operaciones CRUD (Crear, Leer, Actualizar, Eliminar) para clientes.

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;  // Modelo que representa a los clientes.

class CustomerController extends Controller
{
    // Muestra la lista de todos los clientes.
    public function index()
    {
        $customers = Customer::all();  // Obtiene todos los registros de clientes.
        return view('customers.index', compact('customers'));  // Retorna la vista con la lista de clientes.
    }

    // Muestra el formulario para crear un nuevo cliente.
    public function create()
    {
        return view('customers.create');  // Retorna la vista de creación de clientes.
    }

    // Guardo el nuevo cliente en la base de datos.
    public function store(Request $request)
    {
        // Validamos los datos ingresados.
        $request->validate([
            'name' => 'required',
            'lastName' => 'required',
            'key' => 'required|digits:4',
            'subscription' => 'required|in:week,month,year',
        ]);

        // Obtiene el último cliente registrado y genera un nuevo ID.
        $lastCustomer = Customer::orderBy('customerID', 'desc')->first();
        $newID = $lastCustomer ? sprintf('%04d', intval($lastCustomer->customerID) + 1) : '0001';

        // Calcula la fecha de expiración.
        $expirationDate = Customer::calculateExpirationDate($request->input('subscription'));

        // Crea el nuevo cliente en la base de datos.
        Customer::create([
            'customerID' => $newID,
            'name' => $request->input('name'),
            'lastName' => $request->input('lastName'),
            'key' => $request->input('key'),
            'expirationDate' => $expirationDate,
        ]);

        // Redirige a la página de administración con un mensaje de éxito.
        return redirect()->route('administration')->with('success', 'Cliente creado correctamente.');
    }

    // Muestra el formulario de edición para un cliente específico.
    public function edit($id)
    {
        $customer = Customer::find($id);  // Busca al cliente por ID.
        return view('customers.edit', compact('customer'));  // Retorna la vista de edición con los datos del cliente.
    }

    // Actualiza los datos de un cliente existente.
    public function update(Request $request, $id)
    {
        // Valida los datos de entrada.
        $request->validate([
            'name' => 'required',
            'lastName' => 'required',
            'key' => 'required|digits:4',
        ]);

        $customer = Customer::find($id);  // Encuentra al cliente por su ID.

        // Verifica si se especificó una nueva suscripción y calcula la nueva fecha de expiración.
        if ($request->filled('subscription')) {
            $request->validate([
                'subscription' => 'required|in:week,month,year',
            ]);
            $expirationDate = Customer::calculateExpirationDate($request->input('subscription'), $customer->expirationDate);
            $customer->expirationDate = $expirationDate;  // Actualiza la fecha de expiración.
        }

        // Actualiza los datos del cliente.
        $customer->update([
            'name' => $request->input('name'),
            'lastName' => $request->input('lastName'),
            'key' => $request->input('key'),
        ]);

        // Redirige a la página de administración con un mensaje de éxito.
        return redirect()->route('administration')->with('success', 'Cliente actualizado correctamente.');
    }

    // Elimina un cliente de la base de datos.
    public function destroy($id)
    {
        Customer::find($id)->delete();  // Elimina al cliente por ID.
        return redirect()->route('administration')->with('success', 'Cliente eliminado correctamente.');
    }
}
