<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit (opsional, tapi aman)
    protected $table = 'computers';

    // Kolom yang diizinkan untuk diisi secara massal (Mass Assignment)
    protected $fillable = [
        'pc_number',
        'specification',
        'hourly_rate',
        'status',
    ];
}
