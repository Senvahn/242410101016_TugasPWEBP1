<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('produks', function (Blueprint $table) {
        $table->id();
        $table->string('nama_barang');
        $table->string('kategori');
        $table->integer('jumlah');
        $table->string('satuan');
        $table->boolean('status_tersedia')->default(true);
        $table->date('tanggal_masuk');
        $table->timestamps();
    });
}
};
