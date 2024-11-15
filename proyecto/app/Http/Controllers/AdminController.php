<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administration;

class AdminController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $admin = Administration::where('username', $credentials['username'])
            ->where('password', $credentials['password'])
            ->first();

        if ($admin) {
            // Las credenciales son correctas, establecer la sesión
            session(['is_admin' => true]);
            return redirect()->route('administration');
        } else {
            // Las credenciales son incorrectas
            return redirect()->back()->withErrors('Credenciales incorrectas')->withInput();
        }
    }
}
