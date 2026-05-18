<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete()->after('id');
            $table->string('order_code')->nullable()->unique()->after('user_id');
            $table->string('payment_method')->nullable()->after('email');
            $table->decimal('total', 12, 2)->default(0)->after('qty');
            $table->json('items')->nullable()->after('total');
        });

        foreach (DB::table('orders')->get() as $order) {
            DB::table('orders')
                ->where('id', $order->id)
                ->update(['order_code' => 'HNY-' . Str::upper(Str::random(8))]);
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'order_code', 'payment_method', 'total', 'items']);
        });
    }
};
