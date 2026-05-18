<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'nama_pemesan' => 'required|string|max:190',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:190',
            'qty' => 'required|integer|min:1',
            'note' => 'nullable|string|max:500',
        ]);

        $product = Produk::findOrFail($data['produk_id']);
        $items = [
            [
                'produk_id' => $product->id,
                'nama' => $product->nama_barang,
                'qty' => $data['qty'],
                'unit_price' => (float) $product->harga_beli,
                'subtotal' => (float) $product->harga_beli * $data['qty'],
            ],
        ];

        $order = Order::create([
            'user_id' => Auth::id(),
            'produk_id' => $product->id,
            'order_code' => 'HNY-' . Str::upper(Str::random(8)),
            'nama_pemesan' => $data['nama_pemesan'],
            'telepon' => $data['telepon'] ?? null,
            'email' => $data['email'] ?? null,
            'qty' => $data['qty'],
            'payment_method' => 'Bayar di Toko',
            'total' => $items[0]['subtotal'],
            'status' => 'pending',
            'note' => $data['note'] ?? null,
            'items' => $items,
        ]);

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'kode' => $order->order_code,
                'produk' => $product->nama_barang,
                'qty' => $order->qty,
                'nama_pemesan' => $order->nama_pemesan,
                'created_at' => $order->created_at->toDateTimeString(),
            ],
        ]);
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function processCheckout(Request $request)
    {
        $data = $request->validate([
            'nama_pemesan' => 'required|string|max:190',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:190',
            'payment_method' => 'required|in:Cash,QRIS,E-Wallet',
            'note' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $items = [];
        $total = 0;
        foreach ($data['items'] as $item) {
            $product = Produk::findOrFail($item['produk_id']);
            $qty = max(1, intval($item['qty']));
            $subtotal = (float) $product->harga_beli * $qty;
            $items[] = [
                'produk_id' => $product->id,
                'nama' => $product->nama_barang,
                'qty' => $qty,
                'unit_price' => (float) $product->harga_beli,
                'subtotal' => $subtotal,
            ];
            $total += $subtotal;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'produk_id' => $items[0]['produk_id'],
            'order_code' => 'HNY-' . Str::upper(Str::random(8)),
            'nama_pemesan' => $data['nama_pemesan'],
            'telepon' => $data['telepon'] ?? null,
            'email' => $data['email'] ?? null,
            'qty' => array_sum(array_column($items, 'qty')),
            'payment_method' => $data['payment_method'],
            'total' => $total,
            'status' => 'pending',
            'note' => $data['note'] ?? null,
            'items' => $items,
        ]);

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'kode' => $order->order_code,
                'total' => $order->total,
                'status' => $order->status,
            ],
        ]);
    }

    public function historyPage()
    {
        return view('pesanan-saya');
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'nullable|string|max:255',
        ]);

        $query = trim($request->input('query', ''));
        $orders = Order::query();

        if (Auth::check() && !Auth::user()->isAdmin()) {
            $orders->where('user_id', Auth::id());
        }

        if ($query !== '') {
            $orders->where(function ($builder) use ($query) {
                $builder->where('telepon', 'like', "%{$query}%")
                    ->orWhere('order_code', 'like', "%{$query}%")
                    ->orWhere('nama_pemesan', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            });
        }

        if (!Auth::check() && $query === '') {
            return response()->json(['data' => []]);
        }

        if (!Auth::check() && $query !== '') {
            $orders->orWhere('telepon', 'like', "%{$query}%");
        }

        $results = $orders->latest()->limit(50)->get();

        return response()->json([
            'data' => $results->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_code' => $order->order_code,
                    'nama_pemesan' => $order->nama_pemesan,
                    'telepon' => $order->telepon,
                    'email' => $order->email,
                    'payment_method' => $order->payment_method,
                    'total' => $order->total,
                    'status' => $order->status,
                    'created_at' => $order->created_at->format('d M Y H:i'),
                    'items' => $order->items ?? [],
                ];
            }),
        ]);
    }

    public function adminIndex()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $orders = Order::latest()->paginate(20);

        return view('admin.konfirmasi', compact('totalOrders', 'pendingOrders', 'orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $order->update(['status' => $data['status']]);

        return response()->json([
            'success' => true,
            'status' => $order->status,
        ]);
    }
}
