<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AuthController;

// --- ROUTE PUBLIK (Tanpa Token) ---
Route::post('/login', [AuthController::class, 'login']);

Route::get('/rentals', [RentalController::class, 'index']);
Route::get('/rentals/{id}', [RentalController::class, 'show']);

// --- ROUTE TERLINDUNGI (Wajib Bearer Token) ---
Route::middleware('auth:sanctum')->group(function () {
    // Bisa diakses semua yang sudah login (Admin & Kasir)
    Route::post('/rentals', [RentalController::class, 'store']);
    Route::put('/rentals/{id}', [RentalController::class, 'update']);

    // Endpoint Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // KHUSUS ADMIN (Middleware Otorisasi)
    Route::middleware('role:admin')->group(function () {
        Route::delete('/rentals/{id}', [RentalController::class, 'destroy']);
    });
});
