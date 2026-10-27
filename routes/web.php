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
    Route::resource('products', ProductController::class)->except(['index', 'show']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});