<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
use Illuminate\Support\Facades\Schema;

echo 'has column: ' . (Schema::hasColumn('orders', 'payment_proof_path') ? 'yes' : 'no') . PHP_EOL;
$orders = Order::whereNotNull('payment_proof_path')->get();
echo 'orders with file: ' . $orders->count() . PHP_EOL;
foreach ($orders as $order) {
    echo 'id=' . $order->id . ' path=' . $order->payment_proof_path . ' created=' . $order->created_at . PHP_EOL;
}
