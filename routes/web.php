<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Load User Routes
|--------------------------------------------------------------------------
*/
require base_path('routes/user.php');

/*
|--------------------------------------------------------------------------
| Load Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    require base_path('routes/admin.php');
});