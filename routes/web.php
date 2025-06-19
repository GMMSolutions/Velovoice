<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Home route (invoices list)
    Route::get('/', [\App\Http\Controllers\InvoiceController::class, 'index'])->name('home');
    
    // Product Routes
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    
    // Client Routes
    Route::resource('clients', \App\Http\Controllers\ClientController::class);
    
    // Invoice Routes
    Route::resource('invoices', \App\Http\Controllers\InvoiceController::class);
    Route::get('invoices/{invoice}/download', [\App\Http\Controllers\InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('api/products/{product}', [\App\Http\Controllers\InvoiceController::class, 'getProduct'])->name('api.products.show');
});
