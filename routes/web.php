<?php

use Illuminate\Support\Facades\Route;

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