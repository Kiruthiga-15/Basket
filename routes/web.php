<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VariationTypeController;
use App\Http\Controllers\Admin\VariationValueController;
use App\Http\Controllers\Admin\ProductController;


/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home.home');
});

Route::get('/shop', function () {
    return view('shop.shop');
});

Route::get('/cart', function () {
    return view('cart.cart');
});

Route::get('/contact', function () {
    return view('contact.contact');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [LoginController::class, 'showLogin']);
Route::post('/admin/login', [LoginController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('admin.auth')
->prefix('admin')
->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard.dashboard');
    });

    Route::get('/products', [CategoryController::class, 'index']);

    Route::post('/category/store', [CategoryController::class, 'store']);
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('/category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);
    Route::post('/category/status/{id}',[CategoryController::class, 'changeStatus']);

    Route::post('/variation-type/store', [VariationTypeController::class, 'store']);
    Route::get('/variation-type/edit/{id}', [VariationTypeController::class, 'edit']);
    Route::post('/variation-type/update/{id}', [VariationTypeController::class, 'update']);
    Route::delete('/variation-type/delete/{id}', [VariationTypeController::class, 'destroy']);
    Route::post('/variation-type/status/{id}', [VariationTypeController::class, 'status']);

    Route::post('/variation-value/store', [VariationValueController::class, 'store']);
    Route::get('/variation-value/edit/{id}', [VariationValueController::class, 'edit']);
    Route::post('/variation-value/update/{id}', [VariationValueController::class, 'update']);
    Route::delete('/variation-value/delete/{id}', [VariationValueController::class, 'destroy']);
    Route::post('/variation-value/status/{id}', [VariationValueController::class, 'status']);
    Route::get('/variation-value/check', [VariationValueController::class, 'check']);

    Route::post(
        '/products/store',
        [ProductController::class, 'store']
    )->name('products.store');

    Route::get(
        '/products/edit/{id}',
        [ProductController::class, 'edit']
    )->name('products.edit');

    Route::post(
        '/products/update/{id}',
        [ProductController::class, 'update']
    )->name('products.update');

    Route::delete(
        '/products/delete/{id}',
        [ProductController::class, 'destroy']
    )->name('products.delete');

    Route::post(
        '/products/status/{id}',
        [ProductController::class, 'changeStatus']
    )->name('products.status');

    Route::get('/orders', function () {
        return view('admin.orders.orders');
    });

    Route::get('/customers', function () {
        return view('admin.customers.customers');
    });

    Route::get('/settings', function () {
        return view('admin.settings.settings');
    });

    Route::get('/adminprofile', function () {
        return view('admin.adminprofile.profile');
    });

    Route::get('/admin/logout', [LoginController::class, 'logout']);

});