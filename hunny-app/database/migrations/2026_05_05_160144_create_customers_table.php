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
    // Tabel Utama Customer
    Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('nama_customer');
        $table->string('telepon');
        $table->timestamps();
    });

    // Tabel Pivot (Penghubung Customer & Produk)
    Schema::create('customer_produk', function (Blueprint $table) {
        $table->id();
        $table->foreignId('customer_id')->constrained()->onDelete('cascade');
        $table->foreignId('produk_id')->constrained()->onDelete('cascade');
    });
}
};
