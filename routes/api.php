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
| Semua route API didefinisikan di sini.
| Frontend akan mengakses endpoint ini melalui URL: /api/...
|
*/

// 🔑 Auth (tidak butuh token)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 📖 Menu list (public, untuk ditampilkan di aplikasi tanpa login)
Route::get('/menus', [MenuController::class, 'index']);
Route::get('/menus/{id}', [MenuController::class, 'show']);

// 🔒 Butuh token (auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // User
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Menu CRUD (khusus admin / user tertentu)
    Route::post('/menus', [MenuController::class, 'store']);
    Route::put('/menus/{id}', [MenuController::class, 'update']);
    Route::delete('/menus/{id}', [MenuController::class, 'destroy']);

    // Tables
    Route::apiResource('tables', TableController::class);

    // Orders
    Route::apiResource('orders', OrderController::class);
    Route::get('/orders/active', [OrderController::class, 'active']);
    Route::get('/orders/history', [OrderController::class, 'history']);

    // Dashboard
    Route::get('/dashboard', [OrderController::class, 'dashboard']);
});
