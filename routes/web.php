<?php

use App\Http\Controllers\ApprovalController;
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
    // Route Approval
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('customer.approval.index');
    Route::get('/approvals/create', [ApprovalController::class, 'create'])->name('customer.approval.create');
    // Route DB
    // Route Parts
    Route::get('/parts', [DatabasePartController::class, 'index'])->name('customer.database.part.index');
    Route::get('/parts/detail/{part_id}', [DatabasePartController::class, 'showDetails'])->name('customer.database.part.details');
    Route::put('/parts/detail/{part_id}', [DatabasePartController::class, 'update'])->name('customer.database.part.update');
    Route::delete('/parts/delete/{part_id}', [DatabasePartController::class, 'destroy'])->name('customer.database.part.delete');
    Route::get('/parts/import', [DatabasePartController::class, 'showImportForm'])->name('customer.database.part.import.index');
    Route::post('/parts/import', [DatabasePartController::class, 'import'])->name('customer.database.part.import');
    Route::get('/parts/export-template', [DatabasePartController::class, 'exportTemplate'])->name('customer.database.part.export-template');
    Route::get('/parts/export', [DatabasePartController::class, 'export'])->name('customer.database.part.export');

    // Route Services
    Route::get('/services', [DatabaseServiceController::class, 'index'])->name('customer.database.service.index');
    // NEXT: Add route to show details of a service

    // import
    Route::get('/services/import', [DatabaseServiceController::class, 'showImportForm'])->name('customer.database.service.import.index');
    Route::post('/services/import', [DatabaseServiceController::class, 'import'])->name('customer.database.service.import');
    Route::get('/services/export-template', [DatabaseServiceController::class, 'exportTemplate'])->name('customer.database.service.export-template');
    Route::get('/services/export', [DatabaseServiceController::class, 'export'])->name('customer.database.service.export');
});

// routes login admin
Route::get('/login-admin', [LoginAdminController::class, 'showLoginForm'])->middleware('guest:admin')->name('login-admin');
Route::post('/verify-admin', [LoginAdminController::class, 'login'])->name('verify-login-admin');
Route::post('/logout-admin', [LoginAdminController::class, 'logout'])->name('logout-admin');

Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
});
