<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Route
Route::get('admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'adminLogin']);

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
});

// Customer Route
Route::get('customerLogin', [AuthController::class, 'showCustomerLoginForm'])->name('customer.login');
Route::post('customer/login', [AuthController::class, 'customerLogin']);
Route::get('customerRegister', [AuthController::class, 'showCustomerRegisterForm'])->name('customer.register');
Route::post('customer/register', [AuthController::class, 'customerRegister']);

Route::middleware(['auth', 'role:customer'])->prefix('customer')->group(function () {
    Route::get('dashboard', [AuthController::class, 'customerDashboard'])->name('customer.dashboard');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout');