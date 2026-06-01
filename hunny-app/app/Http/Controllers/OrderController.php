<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $paymentProofPath = null;
        if ($request->hasFile('payment_proof') && $request->file('payment_proof')->isValid()) {
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

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
            'payment_proof_path' => $paymentProofPath,
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
        $paymentMethod = $request->input('payment_method');

        $rules = [
            'nama_pemesan' => 'required|string|max:190',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:190',
            'payment_method' => 'required|in:bayar_di_toko,qris,e_wallet,Cash,QRIS,E-Wallet',
            'note' => 'nullable|string|max:500',
            'payment_proof' => 'nullable|image|max:2048',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty' => 'required|integer|min:1',
        ];

        if (in_array($paymentMethod, ['qris', 'e_wallet'], true)) {
            $rules['payment_proof'] = 'required|image|max:2048';
        }

        $data = $request->validate($rules);

        $items = [];
        $total = 0;
        $paymentProofPath = null;

        if ($request->hasFile('payment_proof') && $request->file('payment_proof')->isValid()) {
            $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

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
            'payment_proof_path' => $paymentProofPath,
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

    private function normalizeItems(Order $order): array
    {
        $items = is_array($order->items) ? $order->items : [];
        $product = $order->relationLoaded('produk') ? $order->produk : $order->produk()->first();

        if (!is_array($items) || empty($items)) {
            $qty = max(1, (int) ($order->qty ?? 1));
            $unitPrice = (float) ($product?->harga_beli ?? 0);

            return [[
                'id' => $product?->id ?? null,
                'produk_id' => $product?->id ?? null,
                'name' => $product?->nama_barang ?? 'Produk',
                'nama_barang' => $product?->nama_barang ?? 'Produk',
                'qty' => $qty,
                'price' => $unitPrice,
                'unit_price' => $unitPrice,
                'subtotal' => $qty * $unitPrice,
                'sub_total' => $qty * $unitPrice,
            ]];
        }

        return array_values(array_map(function (array $item) use ($product) {
            $qty = max(1, (int) ($item['qty'] ?? $item['quantity'] ?? 1));
            $unitPrice = (float) ($item['price'] ?? $item['unit_price'] ?? $item['harga_beli'] ?? $product?->harga_beli ?? 0);
            $subtotal = (float) ($item['subtotal'] ?? $item['sub_total'] ?? ($qty * $unitPrice));

            return [
                'id' => $item['id'] ?? $item['produk_id'] ?? $product?->id ?? null,
                'produk_id' => $item['produk_id'] ?? $product?->id ?? null,
                'name' => $item['name'] ?? $item['nama_barang'] ?? $product?->nama_barang ?? 'Produk',
                'nama_barang' => $item['nama_barang'] ?? $item['name'] ?? $product?->nama_barang ?? 'Produk',
                'qty' => $qty,
                'price' => $unitPrice,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
                'sub_total' => $subtotal,
            ];
        }, $items));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'nullable|string|max:255',
        ]);

        $query = trim($request->input('query', ''));
        $orders = Order::query()->with('produk');

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
                    'items' => $this->normalizeItems($order),
                ];
            }),
        ]);
    }

    public function detail(Order $order)
    {
        $order->loadMissing('produk');

        // Authorization: user bisa lihat order miliknya, admin bisa lihat semua, atau guest bisa lihat dengan verifikasi
        if (Auth::check()) {
            // Jika login: hanya bisa lihat miliknya sendiri atau admin
            if (Auth::id() !== $order->user_id && !Auth::user()->isAdmin()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }
        // Jika guest: bisa lihat detail pesanan (verifikasi dilakukan di search)

        return response()->json([
            'data' => [
                'id' => $order->id,
                'order_code' => $order->order_code,
                'nama_pemesan' => $order->nama_pemesan,
                'telepon' => $order->telepon,
                'email' => $order->email,
                'payment_method' => $order->payment_method,
                'payment_proof_path' => $order->payment_proof_path,
                'total' => $order->total,
                'status' => $order->status,
                'note' => $order->note,
                'created_at' => $order->created_at->toDateTimeString(),
                'updated_at' => $order->updated_at->toDateTimeString(),
                'items' => $this->normalizeItems($order),
            ],
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

        $items = is_array($order->items) ? $order->items : json_decode($order->items, true);
        $items = is_array($items) ? $items : [];

        if ($data['status'] === 'confirmed' && $order->status !== 'confirmed') {
            DB::beginTransaction();
            try {
                foreach ($items as $item) {
                    $product = Produk::find($item['produk_id']);
                    $qty = max(1, intval($item['qty'] ?? 0));

                    if (! $product) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Produk pesanan tidak ditemukan.',
                        ], 404);
                    }

                    if ($product->jumlah < $qty) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => "Stok produk {$product->nama_barang} tidak mencukupi.",
                        ], 422);
                    }

                    $product->decrement('jumlah', $qty);
                }

                $order->update(['status' => 'confirmed']);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui status pesanan.',
                ], 500);
            }
        } elseif ($data['status'] === 'cancelled' && $order->status === 'confirmed') {
            DB::beginTransaction();
            try {
                foreach ($items as $item) {
                    $product = Produk::find($item['produk_id']);
                    $qty = max(1, intval($item['qty'] ?? 0));

                    if (! $product) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => 'Produk pesanan tidak ditemukan.',
                        ], 404);
                    }

                    $product->increment('jumlah', $qty);
                }

                $order->update(['status' => 'cancelled']);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui status pesanan.',
                ], 500);
            }
        } else {
            $order->update(['status' => $data['status']]);
        }

        return response()->json([
            'success' => true,
            'status' => $order->status,
        ]);
    }
}
