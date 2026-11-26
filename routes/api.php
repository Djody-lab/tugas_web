<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini adalah tempat mendaftarkan route untuk aplikasi kamu.
| Route di sini otomatis memiliki prefix "/api".
|
*/

// Route bawaan Laravel (boleh dibiarkan)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// --- ROUTE CRUD TUGAS KELOMPOK (WARNET) ---

// Satu baris ini otomatis membuat 5 route:
// GET /rentals, POST /rentals, GET /rentals/{id}, PUT /rentals/{id}, DELETE /rentals/{id}
Route::apiResource('rentals', RentalController::class);
