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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->string('kode_booking')->unique();
        $table->string('nama_pemilik');
        $table->string('email')->unique();
        $table->enum('jenis_layanan', ['Basic Grooming', 'Full Grooming', 'Spa & Treatment', 'Nail Trimming']);
        $table->string('nama_hewan');
        $table->enum('jenis_hewan', ['Anjing', 'Kucing', 'Kelinci', 'Lainnya']);
        $table->date('tanggal_reservasi');
        $table->enum('status', ['pending', 'confirmed', 'done', 'cancelled'])->default('pending');
        $table->string('foto_hewan')->nullable();
        $table->text('catatan')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
