<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\TableController;
use App\Http\Controllers\API\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Semua route API didefinisikan di sini.
| Frontend akan mengakses endpoint ini melalui URL: /api/...
|
*/

// 🔑 Auth (tidak butuh token)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔒 Butuh token (auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // User
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Menu
    Route::apiResource('menus', MenuController::class);

    // Tables
    Route::apiResource('tables', TableController::class);

    // Orders
    Route::apiResource('orders', OrderController::class);
    Route::get('/orders/active', [OrderController::class, 'active']);
    Route::get('/orders/history', [OrderController::class, 'history']);

    // Dashboard
    Route::get('/dashboard', [OrderController::class, 'dashboard']);
});
