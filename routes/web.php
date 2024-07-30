<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('check');
});

Route::get('/check', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 'customer') {
            return redirect()->route('customer.dashboard');
        }
    }
    return redirect()->route('login');
})->name('check');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/customers', [AdminController::class, 'listCustomers'])->name('admin.customers');
    Route::post('/admin/customers', [AdminController::class, 'createCustomer'])->name('admin.createCustomer');
    Route::get('/admin/customers/{id}/edit', [AdminController::class, 'editCustomer'])->name('admin.editCustomer');
    Route::put('/admin/customers/{id}', [AdminController::class, 'updateCustomer'])->name('admin.updateCustomer');
    Route::delete('/admin/customers/{id}', [AdminController::class, 'deleteCustomer'])->name('admin.deleteCustomer');

    Route::post('/admin/videos', [AdminController::class, 'createVideo'])->name('admin.createVideo');
    Route::put('/admin/videos/{id}', [AdminController::class, 'updateVideo'])->name('admin.updateVideo');
    Route::delete('/admin/videos/{id}', [AdminController::class, 'deleteVideo'])->name('admin.deleteVideo');
    Route::patch('/admin/requests/{id}', [AdminController::class, 'manageRequest'])->name('admin.manageRequest');
});

Route::middleware(['auth', 'is_customer'])->group(function () {
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::post('/customer/videos/{videoId}/request', [CustomerController::class, 'requestAccess'])->name('customer.requestAccess');
    Route::get('/customer/accesses/{accessId}/watch', [CustomerController::class, 'watchVideo'])->name('customer.watchVideo');
});
