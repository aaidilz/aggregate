<?php

use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardCustomerController;
use App\Http\Controllers\DatabasePartController;
use App\Http\Controllers\DatabaseServiceController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\LoginCustomerController;
use Illuminate\Support\Facades\Route;

// routes login customer
Route::get('/', [LoginCustomerController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginCustomerController::class, 'showLoginForm'])->middleware('guest:customer')->name('login-customer');
Route::post('/verify-customer', [LoginCustomerController::class, 'login'])->name('verify-login');
Route::post('/logout-customer', [LoginCustomerController::class, 'logout'])->name('logout-customer');

Route::middleware('auth:customer')->prefix('customer')->group(function () {
    Route::get('/', [DashboardCustomerController::class, 'index'])->name('customer.dashboard');
    Route::get('/dashboard', [DashboardCustomerController::class, 'index'])->name('customer.dashboard');

    // Route DB
    // Route Parts
    Route::get('/parts', [DatabasePartController::class, 'index'])->name('parts.index');
    // Route Services
    Route::get('/services', [DatabaseServiceController::class, 'index'])->name('services.index');

});

// routes login admin
Route::get('/login-admin', [LoginAdminController::class, 'showLoginForm'])->middleware('guest:admin')->name('login-admin');
Route::post('/verify-admin', [LoginAdminController::class, 'login'])->name('verify-login-admin');
Route::post('/logout-admin', [LoginAdminController::class, 'logout'])->name('logout-admin');

Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
});
