<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\VariationTypeController;
use App\Http\Controllers\Admin\VariationValueController;
use App\Http\Controllers\Admin\ProductController;

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLogin']);
Route::post('/login', [LoginController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('admin.auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard.dashboard');
    });

    Route::get('/products', [CategoryController::class, 'index']);

    // CATEGORY
    Route::post('/category/store', [CategoryController::class, 'store']);
    Route::get('/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::post('/category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy']);
    Route::post('/category/status/{id}', [CategoryController::class, 'changeStatus']);

    // VARIATION TYPE
    Route::post('/variation-type/store', [VariationTypeController::class, 'store']);
    Route::get('/variation-type/edit/{id}', [VariationTypeController::class, 'edit']);
    Route::post('/variation-type/update/{id}', [VariationTypeController::class, 'update']);
    Route::delete('/variation-type/delete/{id}', [VariationTypeController::class, 'destroy']);
    Route::post('/variation-type/status/{id}', [VariationTypeController::class, 'status']);

    // VARIATION VALUE
    Route::post('/variation-value/store', [VariationValueController::class, 'store']);
    Route::get('/variation-value/edit/{id}', [VariationValueController::class, 'edit']);
    Route::post('/variation-value/update/{id}', [VariationValueController::class, 'update']);
    Route::delete('/variation-value/delete/{id}', [VariationValueController::class, 'destroy']);
    Route::post('/variation-value/status/{id}', [VariationValueController::class, 'status']);
    Route::get('/variation-value/check', [VariationValueController::class, 'check']);

    // PRODUCTS
    Route::post('/products/store', [ProductController::class, 'store']);
    Route::get('/products/edit/{id}', [ProductController::class, 'edit']);
    Route::post('/products/update/{id}', [ProductController::class, 'update']);
    Route::delete('/products/delete/{id}', [ProductController::class, 'destroy']);
    Route::post('/products/status/{id}', [ProductController::class, 'changeStatus']);
    Route::delete('/products/delete-image/{id}', [ProductController::class, 'deleteImage']);

    // OTHER PAGES
    Route::get('/orders', fn() => view('admin.orders.orders'));
    Route::get('/customers', fn() => view('admin.customers.customers'));
    Route::get('/settings', fn() => view('admin.settings.settings'));
    Route::get('/adminprofile', fn() => view('admin.adminprofile.profile'));

    Route::get('/logout', [LoginController::class, 'logout']);
});