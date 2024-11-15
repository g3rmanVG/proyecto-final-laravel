<?php
// app/Http/Controllers/CustomerController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lastName' => 'required',
            'key' => 'required|digits:4',
            'subscription' => 'required|in:week,month,year',
        ]);

        $lastCustomer = Customer::orderBy('customerID', 'desc')->first();
        $newID = $lastCustomer ? sprintf('%04d', intval($lastCustomer->customerID) + 1) : '0001';

        $expirationDate = Customer::calculateExpirationDate($request->input('subscription'));

        Customer::create([
            'customerID' => $newID,
            'name' => $request->input('name'),
            'lastName' => $request->input('lastName'),
            'key' => $request->input('key'),
            'expirationDate' => $expirationDate,
        ]);

        return redirect()->route('administration')->with('success', 'Cliente creado correctamente.');
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'lastName' => 'required',
            'key' => 'required|digits:4',
        ]);

        $customer = Customer::find($id);

        if ($request->filled('subscription')) {
            $request->validate([
                'subscription' => 'required|in:week,month,year',
            ]);
            $expirationDate = Customer::calculateExpirationDate($request->input('subscription'), $customer->expirationDate);
            $customer->expirationDate = $expirationDate;
        }

        $customer->update([
            'name' => $request->input('name'),
            'lastName' => $request->input('lastName'),
            'key' => $request->input('key'),
        ]);

        return redirect()->route('administration')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy($id)
    {
        Customer::find($id)->delete();
        return redirect()->route('administration')->with('success', 'Cliente eliminado correctamente.');
    }
}
