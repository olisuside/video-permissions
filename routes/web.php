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


// Middleware guest untuk login dan register
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Middleware auth untuk halaman yang memerlukan autentikasi
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Routes for Customers
    Route::get('/admin/customers', [AdminController::class, 'listCustomers'])->name('admin.customers');
    Route::post('/admin/customers', [AdminController::class, 'createCustomer'])->name('admin.createCustomer');
    Route::get('/admin/customers/{id}/edit', [AdminController::class, 'editCustomer'])->name('admin.editCustomer');
    Route::put('/admin/customers/{id}', [AdminController::class, 'updateCustomer'])->name('admin.updateCustomer');
    Route::delete('/admin/customers/{id}', [AdminController::class, 'deleteCustomer'])->name('admin.deleteCustomer');

    // Routes for Videos
    Route::get('/admin/videos', [AdminController::class, 'listVideos'])->name('admin.videos');
    Route::post('/admin/videos', [AdminController::class, 'createVideo'])->name('admin.createVideo');
    Route::put('/admin/videos/{id}', [AdminController::class, 'updateVideo'])->name('admin.updateVideo');
    Route::delete('/admin/videos/{id}', [AdminController::class, 'deleteVideo'])->name('admin.deleteVideo');

    // Routes for Requests
    Route::get('/admin/requests', [AdminController::class, 'listRequests'])->name('admin.requests');
    Route::patch('/admin/requests/{id}', [AdminController::class, 'manageRequest'])->name('admin.manageRequest');
});


Route::middleware(['auth', 'is_customer'])->group(function () {
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::post('/customer/videos/{videoId}/request', [CustomerController::class, 'requestAccess'])->name('customer.requestAccess');
    Route::get('/customer/accesses/{accessId}/watch', [CustomerController::class, 'watchVideo'])->name('customer.watchVideo');
});
