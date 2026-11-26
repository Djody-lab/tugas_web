<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $table = 'rentals';

    protected $fillable = [
        'customer_id',
        'computer_id',
        'start_time',
        'end_time',
        'total_price',
    ];

    // --- BONUS: Relasi Eloquent (Sangat disarankan untuk tugas) ---

    // Relasi: 1 Transaksi Rental milik 1 Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi: 1 Transaksi Rental milik 1 Komputer
    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }
}
