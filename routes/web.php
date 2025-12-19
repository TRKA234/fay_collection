<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Front\AuthController as FrontAuthController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderAdminController;

// =====================
// CUSTOMER AUTH
// =====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [FrontAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [FrontAuthController::class, 'login'])->name('login.post');

    Route::get('/register', [FrontAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [FrontAuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [FrontAuthController::class, 'logout'])->name('logout');

// =====================
// ADMIN AUTH
// =====================
Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
});

// =====================
// ADMIN AREA (ADMIN ONLY)
// =====================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', ProductAdminController::class)->except(['show']);
        Route::resource('categories', CategoryAdminController::class)->except(['show']);
        Route::resource('orders', OrderAdminController::class);
    });

// =====================
// FRONT (PUBLIC)
// =====================
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// =====================
// CART
// =====================
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::put('/update/{product}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');

    // contoh checkout (WAJIB CUSTOMER)
    // Route::post('/checkout', [CartController::class, 'checkout'])
    //     ->middleware(['auth', 'role:customer'])
    //     ->name('checkout');
});
