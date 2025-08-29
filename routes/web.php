<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Route
Route::get('admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'adminLogin']);

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
    // product
    Route::resource('products', ProductController::class);
    Route::post('/products/import-csv', [ProductController::class, 'importCsv'])->name('admin.products.import.csv');
    // order
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

});

// Customer Route
Route::get('customer/login', [AuthController::class, 'showCustomerLoginForm'])->name('customer.login');
Route::post('customer/login', [AuthController::class, 'customerLogin']);
Route::get('customer/register', [AuthController::class, 'showCustomerRegisterForm'])->name('customer.register');
Route::post('customer/register', [AuthController::class, 'customerRegister']);

Route::middleware(['auth', 'role:customer'])->prefix('customer')->group(function () {
    Route::get('dashboard', [AuthController::class, 'customerDashboard'])->name('customer.dashboard');
     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout');