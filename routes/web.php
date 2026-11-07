<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('login');
})->name('login');;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/inventory', [ProductController::class, 'index'])->name('inventory');

    Route::get('/products/new/cigarettes', [ProductController::class, 'createCigarette'])->name('products.create.cigarette');
    Route::get('/products/new/softdrinks', [ProductController::class, 'createSoftdrink'])->name('products.create.softdrink');
    Route::get('/products/new/biscuits',   [ProductController::class, 'createBiscuit'])->name('products.create.biscuit');

    Route::resource('products', ProductController::class)->except(['index', 'show', 'create']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

