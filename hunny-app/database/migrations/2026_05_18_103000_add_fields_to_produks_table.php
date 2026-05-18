<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->string('kode_barang')->nullable()->unique()->after('id');
            $table->decimal('harga_beli', 12, 2)->default(0)->after('satuan');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete()->after('harga_beli');
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropColumn(['supplier_id','harga_beli','kode_barang']);
        });
    }
};
