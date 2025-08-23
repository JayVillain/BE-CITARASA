<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\TableController;
use App\Http\Controllers\API\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua route API didefinisikan di sini.
| Frontend akan mengakses endpoint ini melalui URL: /api/...
*/

// Auth (public)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Menu (public)
Route::get('/menus', [MenuController::class, 'index']);
Route::get('/menus/{id}', [MenuController::class, 'show']);

// Protected (butuh token sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // User
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Menu (CRUD untuk admin)
    Route::apiResource('menus', MenuController::class)->except(['index', 'show']);

    // Tables
    Route::apiResource('tables', TableController::class);

    // Orders (custom route harus ditulis sebelum apiResource)
    Route::get('/orders/active', [OrderController::class, 'active']);
    Route::get('/orders/history', [OrderController::class, 'history']);
    Route::get('/dashboard', [OrderController::class, 'dashboard']);
    Route::apiResource('orders', OrderController::class);
});
