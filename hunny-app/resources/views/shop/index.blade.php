@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-2xl font-bold">Toko Hunny - Produk</h1>
            <p class="text-sm text-gray-500 mt-1">Tambahkan produk ke keranjang dan checkout dengan detail pembayaran.</p>
        </div>
        <div class="space-y-2 text-right">
            <div class="text-sm text-gray-600">Keranjang saat ini:</div>
            <div class="text-xl font-semibold"><span id="cartCount">0</span> item</div>
            <a id="checkoutButton" href="{{ route('checkout') }}" class="inline-block bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg transition disabled:opacity-50" style="pointer-events:none; opacity:0.6;">Checkout Sekarang</a>
        </div>
    </div>

    <div id="shopList" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($produks as $produk)
            <div class="bg-white rounded-xl shadow p-4">
                <h3 class="font-semibold text-gray-800">{{ $produk->nama_barang }}</h3>
                <p class="text-sm text-gray-500">Kategori: {{ $produk->kategori }} &middot; Stok: {{ $produk->jumlah }} {{ $produk->satuan }}</p>
                <p class="mt-2 text-lg font-semibold text-pink-600">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</p>
                <div class="mt-4 flex items-center gap-3">
                    <input type="number" min="1" value="1" class="order-qty w-20 border rounded px-2 py-1" />
                    <button data-id="{{ $produk->id }}" data-name="{{ $produk->nama_barang }}" data-price="{{ $produk->harga_beli }}" data-stock="{{ $produk->jumlah }}" class="add-cart-btn bg-pink-500 hover:bg-pink-600 text-white px-3 py-1 rounded">Tambahkan</button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Ringkasan Keranjang</h2>
        <div id="cartPreview" class="space-y-3 text-sm text-gray-700">
            <p class="text-gray-500">Keranjang kosong. Tambahkan produk untuk melanjutkan ke checkout.</p>
        </div>
    </div>
</div>

<script>
    const CART_KEY = 'hunny_cart';
    const cartCountEl = document.getElementById('cartCount');
    const checkoutButton = document.getElementById('checkoutButton');
    const cartPreview = document.getElementById('cartPreview');
    const shopList = document.getElementById('shopList');

    function loadCart() {
        return JSON.parse(localStorage.getItem(CART_KEY)) || [];
    }

    function saveCart(cart) {
        localStorage.setItem(CART_KEY, JSON.stringify(cart));
        renderCart();
    }

    function formatRupiah(number) {
        return number.toLocaleString('id-ID');
    }

    function renderCart() {
        const cart = loadCart();
        cartCountEl.textContent = cart.reduce((sum, item) => sum + item.qty, 0);

        if (cart.length === 0) {
            cartPreview.innerHTML = '<p class="text-gray-500">Keranjang kosong. Tambahkan produk untuk melanjutkan ke checkout.</p>';
            checkoutButton.style.pointerEvents = 'none';
            checkoutButton.style.opacity = '0.6';
            return;
        }

        checkoutButton.style.pointerEvents = 'auto';
        checkoutButton.style.opacity = '1';

        const rows = cart.map(item => {
            return `<div class="flex items-center justify-between gap-3 p-3 border rounded-lg">
                <div>
                    <div class="font-medium">${item.name}</div>
                    <div class="text-xs text-gray-500">Qty: ${item.qty} × Rp ${formatRupiah(item.price)}</div>
                </div>
                <div class="text-right text-sm text-gray-700">Rp ${formatRupiah(item.subtotal)}</div>
            </div>`;
        }).join('');

        const total = cart.reduce((sum, item) => sum + item.subtotal, 0);
        cartPreview.innerHTML = `${rows}
            <div class="mt-4 border-t pt-4 text-right text-base font-semibold">
                Total: Rp ${formatRupiah(total)}
            </div>`;
    }

    function addToCart(productId, name, price, stock, qty) {
        const cart = loadCart();
        const existing = cart.find(item => item.productId === productId);
        const nextQty = Math.min(stock, (existing ? existing.qty : 0) + qty);

        if (nextQty <= 0) {
            alert('Jumlah harus lebih besar dari 0.');
            return;
        }

        if (nextQty > stock) {
            alert('Stok tidak mencukupi.');
            return;
        }

        if (existing) {
            existing.qty = nextQty;
            existing.subtotal = existing.qty * price;
        } else {
            cart.push({
                productId,
                name,
                price,
                qty,
                subtotal: qty * price,
            });
        }

        saveCart(cart);
        alert(`${name} berhasil ditambahkan ke keranjang.`);
    }

    shopList?.addEventListener('click', function (event) {
        const button = event.target.closest('.add-cart-btn');
        if (!button) return;

        const productId = parseInt(button.dataset.id, 10);
        const name = button.dataset.name;
        const price = parseFloat(button.dataset.price) || 0;
        const stock = parseInt(button.dataset.stock, 10) || 0;
        const qtyInput = button.closest('div').querySelector('.order-qty');
        const qty = Math.max(1, parseInt(qtyInput?.value, 10) || 1);

        addToCart(productId, name, price, stock, qty);
    });

    renderCart();
</script>

@endsection
