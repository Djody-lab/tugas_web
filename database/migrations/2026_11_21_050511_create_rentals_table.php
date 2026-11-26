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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel customers dan computers (Foreign Key)
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('computer_id')->constrained()->onDelete('cascade');

            $table->dateTime('start_time'); // Waktu mulai sewa
            $table->dateTime('end_time')->nullable(); // Waktu selesai (kosong jika masih main)
            $table->decimal('total_price', 10, 2)->nullable(); // Dihitung saat selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
