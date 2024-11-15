<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/access', function () {
    return view('access');
})->name('access');

Route::post('/access-verify', [AccessController::class, 'verify'])->name('access.verify');

Route::post('/admin-authenticate', [AdminController::class, 'authenticate'])->name('admin.authenticate');

Route::get('/administration', function () {
    if (!session('is_admin')) {
        return redirect()->route('admin.login');
    }
    $customers = \App\Models\Customer::all();
    return view('administration', compact('customers'));
})->name('administration');

Route::resource('customers', CustomerController::class);
