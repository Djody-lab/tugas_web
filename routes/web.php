<?php

use Illuminate\Support\Facades\Route;
use App\Models\Rental;
use App\Models\Customer;
use App\Models\Computer;

Route::get('/rentals', function () {
    $rentals = Rental::with(['customer', 'computer'])->get();
    $customers = Customer::all();
    $computers = Computer::all();

    // Kirim ketiga data ini ke view
    return view('rentals.index', compact('rentals', 'customers', 'computers'));
});
