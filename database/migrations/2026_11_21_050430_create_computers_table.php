<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('computers', function (Blueprint $table) {
            $table->id();
            $table->string('pc_number')->unique(); // Contoh: "PC-01", "VIP-02"
            $table->string('specification');       // Contoh: "Core i7, RTX 3060"
            $table->decimal('hourly_rate', 10, 2); // Harga sewa per jam
            $table->string('status')->default('available'); // available, in_use, maintenance
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computers');
    }
};
