<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;

$filePath = __DIR__ . '/public/images/payment/qris.jpg';
if (!file_exists($filePath)) {
    echo "Sample file not found: $filePath\n";
    exit(1);
}

// Create a temporary copy for UploadedFile
$tmpPath = sys_get_temp_dir() . '/temp_test_upload.jpg';
copy($filePath, $tmpPath);

$uploadedFile = new UploadedFile(
    $tmpPath,
    'qris.jpg',
    'image/jpeg',
    null,
    true
);

$request = Request::create('/checkout', 'POST', [
    'nama_pemesan' => 'Test User',
    'telepon' => '081234567890',
    'email' => 'test@example.com',
    'payment_method' => 'qris',
    'note' => 'Test payment proof',
    'items' => [
        ['produk_id' => 1, 'qty' => 1],
    ],
], [], ['payment_proof' => $uploadedFile]);

$controller = new OrderController();
$response = $controller->processCheckout($request);

if (method_exists($response, 'getContent')) {
    echo $response->getContent() . PHP_EOL;
}

if (isset($response->original['order']['id'])) {
    echo 'Created order ID: ' . $response->original['order']['id'] . PHP_EOL;
}
