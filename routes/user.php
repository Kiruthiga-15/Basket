<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\AuthController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home.home');
});

/* ==========================
   AUTH ROUTES
========================== */
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/* ==========================
   SHOP ROUTES
========================== */
Route::get('/shop', [ShopController::class, 'index']);
Route::get('/api/products', [ShopController::class, 'getProducts']);

/* ==========================
   WISHLIST ROUTES
========================== */
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/add', [WishlistController::class, 'add']);
    Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'remove']);
    Route::post('/wishlist/check', [WishlistController::class, 'check']);
});

Route::get('/cart', function () {
    return view('cart.cart');
});

Route::get('/contact', function () {
    return view('contact.contact');
});