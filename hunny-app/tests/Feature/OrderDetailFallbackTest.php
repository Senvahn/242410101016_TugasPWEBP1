<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Produk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderDetailFallbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_detail_route_uses_product_fallback_when_items_json_is_empty(): void
    {
        $product = Produk::create([
            'nama_barang' => 'Roti Tawar',
            'kategori' => 'Makanan',
            'jumlah' => 10,
            'satuan' => 'pcs',
            'status_tersedia' => true,
            'tanggal_masuk' => now()->toDateString(),
            'harga_beli' => 15000,
        ]);

        $order = Order::create([
            'user_id' => null,
            'produk_id' => $product->id,
            'order_code' => 'HNY-TEST-001',
            'nama_pemesan' => 'Budi',
            'telepon' => '08123456789',
            'email' => 'budi@example.com',
            'qty' => 2,
            'payment_method' => 'Cash',
            'total' => 30000,
            'status' => 'pending',
            'note' => 'Test fallback',
            'items' => [],
        ]);

        $response = $this->getJson("/orders/{$order->id}");

        $response->assertOk();
        $response->assertJsonPath('data.items.0.name', 'Roti Tawar');
        $response->assertJsonPath('data.items.0.qty', 2);
        $response->assertJsonPath('data.items.0.price', 15000);
        $response->assertJsonPath('data.items.0.subtotal', 30000);
    }
}
