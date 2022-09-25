<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\product\api\ProductController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
});
Route::group(['prefix' => 'auth', 'middleware' => 'auth:api'], function () {
    Route::delete('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
});

Route::group(['prefix' => 'product-admin'], function () {
    Route::get('list', [ProductController::class, 'index']);
    Route::get('list-product-category', [ProductController::class, 'index_product_category']);
});