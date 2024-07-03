<?php

use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\LoginCustomerController;
use Illuminate\Support\Facades\Route;

// routes login customer
Route::get('/', [LoginCustomerController::class, 'showLoginForm']);
Route::get('/login', [LoginCustomerController::class, 'showLoginForm'])->middleware('guest:customer')->name('login-customer');
Route::post('/verify-customer', [LoginCustomerController::class, 'login'])->middleware('guest:customer')->name('verify-login');
Route::post('/logout-customer', [LoginCustomerController::class, 'logout'])->middleware('auth:customer')->name('logout-customer');

Route::middleware('auth:customer')->prefix('customer')->group(function () {
    // routes dashboard customer
});

// routes login admin
Route::get('/admin', [LoginAdminController::class, 'showLoginForm']);
Route::get('/login-admin', [LoginAdminController::class, 'showLoginForm'])->middleware('guest:admin')->name('login-admin');
Route::post('/verify-admin', [LoginAdminController::class, 'login'])->middleware('guest:admin')->name('verify-login-admin');
Route::post('/logout-admin', [LoginAdminController::class, 'logout'])->middleware('auth:admin')->name('logout-admin');

Route::middleware('auth:admin')->prefix('admin')->group(function () {
    // routes dashboard admin
});
