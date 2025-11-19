<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderAdminController;



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

    // Kelola kategori
    Route::resource('categories', CategoryAdminController::class)->except(['show']);

    // Kelola pesanan
    Route::resource('orders', OrderAdminController::class);
});

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Cart routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::put('/update/{product}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});
