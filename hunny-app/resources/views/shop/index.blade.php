@extends('layouts.app')
@section('page-content-class', 'fullwidth')

@section('content')
<div class="container shop-page-container">
    <div class="shop-page-inner">
        <section class="shop-topbar">
            <div class="shop-topbar-grid">
                <div class="shop-hero-copy">
                    <p class="shop-label">Hunny Pet Care</p>
                    <h1 class="shop-title">Toko Hunny - Produk</h1>
                    <p class="shop-description">Jelajahi produk perawatan hewan peliharaan dengan tampilan profesional, ringkas, dan mudah ditambahkan ke keranjang.</p>
                </div>
                <div class="shop-hero-actions">
                    <div class="shop-status-card">
                        <div class="shop-status-label">Item di keranjang</div>
                        <div id="cartCount" class="shop-status-value">0</div>
                    </div>
                    <a id="checkoutButton" href="{{ route('checkout') }}" class="btn btn-accent checkout-button disabled" aria-disabled="true">Checkout Sekarang</a>
                </div>
            </div>
        </section>

        <section class="shop-layout">
            <div class="shop-list-panel">
            @php
                $categories = $produks->pluck('kategori')->filter()->unique()->values();
            @endphp
            <div class="shop-toolbar">
                <div class="shop-toolbar-copy">
                    <h2 class="shop-section-title">Daftar Produk</h2>
                    <p class="shop-section-text">Semua produk tersedia ditampilkan di halaman ini dengan kategori dan stok langsung.</p>
                </div>
                <div class="shop-available-count">
                    <i class="fas fa-box-open"></i> {{ $produks->count() }} produk tersedia
                </div>
                <div class="shop-filters">
                    <button class="shop-filter-chip active" data-category="all">Semua</button>
                    @foreach($categories as $category)
                        <button class="shop-filter-chip" data-category="{{ $category }}">{{ $category }}</button>
                    @endforeach
                </div>
            </div>

            <div id="shopList" class="products-grid">
                @forelse($produks as $produk)
                    <article class="product-card-shop" data-category="{{ $produk->kategori }}">
                        <div class="product-thumb">
                            <span class="product-badge">{{ $produk->kategori ?? 'Umum' }}</span>
                            @if($produk->foto_produk)
                                <img class="product-thumb-image" src="{{ asset('storage/' . $produk->foto_produk) }}" alt="{{ $produk->nama_barang }}">
                            @else
                                <span class="product-thumb-initial">{{ strtoupper(substr($produk->nama_barang, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-category">Kategori</div>
                            <h3 class="product-name">{{ $produk->nama_barang }}</h3>
                            <p class="product-unit">Stok: {{ $produk->jumlah }} {{ $produk->satuan }}</p>
                            <p class="product-description">Nikmati kualitas produk Hunny Pet Care untuk kebutuhan makanan, perawatan, dan aksesoris hewan peliharaan.</p>
                            <div class="product-price-row">
                                <div class="product-price">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</div>
                            </div>
                            <div class="product-actions">
                                <input type="number" min="1" value="1" class="product-qty" aria-label="Jumlah {{ $produk->nama_barang }}" />
                                <button type="button" data-id="{{ $produk->id }}" data-name="{{ $produk->nama_barang }}" data-price="{{ $produk->harga_beli }}" data-stock="{{ $produk->jumlah }}" class="shop-add-button">Tambahkan</button>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="shop-empty-state">
                        Tidak ada produk yang tersedia saat ini. Silakan kembali nanti atau hubungi admin.
                    </div>
                @endforelse
            </div>
        </div>

        <aside class="cart-panel">
            <div class="cart-panel-header">
                <div>
                    <p class="shop-panel-label">Keranjang Belanja</p>
                    <h2 class="shop-panel-title">Ringkasan</h2>
                </div>
            </div>
            <div id="cartPreview" class="cart-preview">
                <p class="cart-empty">Keranjang kosong. Tambahkan produk untuk melanjutkan ke checkout.</p>
            </div>
            <div class="cart-summary-footer">
                <span>Total</span>
                <span id="cartTotal">Rp 0</span>
            </div>
        </aside>
    </section>
    </div>
</div>

<div id="cartToast" class="cart-toast" role="status" aria-live="polite"></div>

<script>
    const CART_KEY = 'hunny_cart';
    const cartCountEl = document.getElementById('cartCount');
    const checkoutButton = document.getElementById('checkoutButton');
    const cartPreview = document.getElementById('cartPreview');
    const cartTotalEl = document.getElementById('cartTotal');
    const shopList = document.getElementById('shopList');
    const toastEl = document.getElementById('cartToast');

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

    function showToast(message) {
        if (!toastEl) return;
        toastEl.textContent = message;
        toastEl.classList.add('show');
        setTimeout(() => toastEl.classList.remove('show'), 2200);
    }

    function renderCart() {
        const cart = loadCart();
        cartCountEl.textContent = cart.reduce((sum, item) => sum + item.qty, 0);

        if (cart.length === 0) {
            cartPreview.innerHTML = '<p class="cart-empty">Keranjang kosong. Tambahkan produk untuk melanjutkan ke checkout.</p>';
            checkoutButton.setAttribute('aria-disabled', 'true');
            checkoutButton.classList.add('disabled');
            cartTotalEl.textContent = 'Rp 0';
            return;
        }

        checkoutButton.removeAttribute('aria-disabled');
        checkoutButton.classList.remove('disabled');

        const rows = cart.map(item => {
            return `<div class="cart-summary-item">
                <div>
                    <div class="cart-summary-title">${item.name}</div>
                    <div class="cart-summary-meta">Qty: ${item.qty} × Rp ${formatRupiah(item.price)}</div>
                </div>
                <div class="cart-summary-details">
                    <div class="cart-qty-row">
                        <button type="button" data-id="${item.productId}" class="cart-qty-button cart-decrement-button" aria-label="Kurangi jumlah">−</button>
                        <span class="cart-qty-value">${item.qty}</span>
                        <button type="button" data-id="${item.productId}" class="cart-qty-button cart-increment-button" aria-label="Tambah jumlah">+</button>
                    </div>
                    <div class="cart-summary-meta">Qty: ${item.qty} × Rp ${formatRupiah(item.price)}</div>
                    <div class="cart-summary-total">Rp ${formatRupiah(item.subtotal)}</div>
                    <button type="button" data-id="${item.productId}" class="cart-remove-button">Hapus</button>
                </div>
            </div>`;
        }).join('');

        const total = cart.reduce((sum, item) => sum + item.subtotal, 0);
        cartPreview.innerHTML = rows;
        cartTotalEl.textContent = `Rp ${formatRupiah(total)}`;
    }

    function filterProducts(selectedCategory) {
        const cards = document.querySelectorAll('.product-card-shop');
        cards.forEach(card => {
            const cardCategory = card.dataset.category?.trim() || 'Umum';
            const isVisible = selectedCategory === 'all' || cardCategory === selectedCategory;
            if (isVisible) {
            card.classList.remove('hidden');
            } 
            else {
            card.classList.add('hidden');
            }
        });
    }

    function addToCart(productId, name, price, stock, qty) {
        const cart = loadCart();
        const existing = cart.find(item => item.productId === productId);
        const nextQty = Math.min(stock, (existing ? existing.qty : 0) + qty);

        if (qty <= 0) {
            showToast('Jumlah harus lebih besar dari 0.');
            return;
        }

        if (nextQty > stock) {
            showToast('Stok tidak mencukupi.');
            return;
        }

        if (existing) {
            existing.qty = nextQty;
            existing.stock = existing.stock || stock;
            existing.subtotal = existing.qty * price;
        } else {
            cart.push({
                productId,
                name,
                price,
                qty,
                stock,
                subtotal: qty * price,
            });
        }

        saveCart(cart);
        showToast(`${name} berhasil ditambahkan ke keranjang.`);
    }

    document.body.addEventListener('click', function (event) {
        const addButton = event.target.closest('.shop-add-button');
        if (addButton) {
            const productId = parseInt(addButton.dataset.id, 10);
            const name = addButton.dataset.name;
            const price = parseFloat(addButton.dataset.price) || 0;
            const stock = parseInt(addButton.dataset.stock, 10) || 0;
            const qtyInput = addButton.closest('article')?.querySelector('.product-qty');
            const qty = Math.max(1, parseInt(qtyInput?.value, 10) || 1);
            addToCart(productId, name, price, stock, qty);
            return;
        }

        const incrementButton = event.target.closest('.cart-increment-button');
        if (incrementButton) {
            const productId = parseInt(incrementButton.dataset.id, 10);
            incrementCart(productId);
            return;
        }

        const decrementButton = event.target.closest('.cart-decrement-button');
        if (decrementButton) {
            const productId = parseInt(decrementButton.dataset.id, 10);
            decrementCart(productId);
            return;
        }

        const removeButton = event.target.closest('.cart-remove-button');
        if (removeButton) {
            const productId = parseInt(removeButton.dataset.id, 10);
            removeFromCart(productId);
            return;
        }

        const filterButton = event.target.closest('.shop-filter-chip');
        if (filterButton) {
            const selectedCategory = filterButton.dataset.category;
            document.querySelectorAll('.shop-filter-chip').forEach(btn => btn.classList.toggle('active', btn === filterButton));
            filterProducts(selectedCategory);
            return;
        }
    });

    function removeFromCart(productId) {
        const cart = loadCart();
        const updated = cart.filter(item => item.productId !== productId);
        saveCart(updated);
        showToast('Item dihapus dari keranjang.');
    }

    function incrementCart(productId) {
        const cart = loadCart();
        const item = cart.find(item => item.productId === productId);
        if (!item) return;

        if (item.qty >= item.stock) {
            showToast('Stok tidak mencukupi.');
            return;
        }

        item.qty += 1;
        item.subtotal = item.qty * item.price;
        saveCart(cart);
        showToast(`${item.name} berhasil ditambahkan.`);
    }

    function decrementCart(productId) {
        const cart = loadCart();
        const itemIndex = cart.findIndex(item => item.productId === productId);
        if (itemIndex !== -1) {
            const item = cart[itemIndex];
            if (item.qty > 1) {
                item.qty -= 1;
                item.subtotal = item.qty * item.price;
                saveCart(cart);
                showToast(`${item.name} berhasil dikurangi.`);
            } else {
                cart.splice(itemIndex, 1);
                saveCart(cart);
                showToast(`${item.name} dihapus dari keranjang.`);
            }
        }
    }

    renderCart();
</script>

@endsection
