<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\DashboardController;



// Route::get('/', function () {
//     return view('landing');
// });

// ======== AUTH (LOGIN / LOGOUT) ========
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ======== ROUTE ADMIN (HARUS LOGIN) ========
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard utama admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola produk
    Route::resource('products', ProductAdminController::class)->except(['show']);
});

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
