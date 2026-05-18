@extends('layouts.customer')

@section('title', 'Pesanan Saya')

@section('content')
<div class="breadcrumb">
    <a href="{{ url('/') }}">Beranda</a>
    <i class="fas fa-chevron-right"></i>
    <a href="{{ url('/customer') }}">Toko</a>
    <i class="fas fa-chevron-right"></i>
    <span>Pesanan Saya</span>
</div>

<div class="cust-container">
    <div class="section-header">
        <h2>Lacak Pesanan Anda</h2>
        <p>Masukkan nomor telepon atau kode pesanan untuk melihat status pesanan Anda.</p>
    </div>

    <div class="card shadow-sm" style="max-width: 600px; margin-bottom: 30px;">
        <div class="search-box-wa">
            <input type="text" id="querySearch" placeholder="Nomor telepon / kode pesanan" class="form-control">
            <button class="btn btn-accent" id="searchButton">Cari Pesanan</button>
        </div>
    </div>

    <div id="orderList" class="order-grid">
        <div class="empty-state">
            <i class="fas fa-search fa-3x"></i>
            <p>Masukkan nomor telepon atau kode pesanan, lalu tekan Cari.</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const searchUrl = '{{ route('orders.search') }}';
    const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

    function renderOrders(orders) {
        const container = document.getElementById('orderList');

        if (!orders.length) {
            container.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-times-circle fa-3x"></i>
                    <p>Pesanan tidak ditemukan. Periksa kembali nomor telepon atau kode pesanan.</p>
                </div>`;
            return;
        }

        container.innerHTML = orders.map(order => `
            <div class="card order-card shadow-sm">
                <div class="order-card-header">
                    <span class="order-kode">${order.order_code}</span>
                    <span class="status-tag status-${order.status.toLowerCase().replace(/\s/g, '-')}">${order.status}</span>
                </div>
                <div class="order-card-body">
                    <p><i class="fas fa-user"></i> ${order.nama_pemesan}</p>
                    <p><i class="fas fa-phone"></i> ${order.telepon || order.email || 'Tanpa kontak'}</p>
                    <p><i class="fas fa-money-bill-wave"></i> Total: <strong>Rp ${Number(order.total).toLocaleString('id-ID')}</strong></p>
                    <p><i class="fas fa-credit-card"></i> Metode: ${order.payment_method || 'Bayar di Toko'}</p>
                    <p><i class="fas fa-calendar"></i> ${order.created_at}</p>
                </div>
            </div>
        `).join('');
    }

    async function fetchOrders(query = '') {
        if (!query && !isAuthenticated) {
            renderOrders([]);
            return;
        }

        const url = new URL(searchUrl, window.location.origin);
        if (query) {
            url.searchParams.set('query', query);
        }

        const response = await fetch(url.toString(), {
            headers: { 'Accept': 'application/json' }
        });
        const json = await response.json();
        renderOrders(json.data || []);
    }

    document.getElementById('searchButton').addEventListener('click', () => {
        const query = document.getElementById('querySearch').value.trim();
        fetchOrders(query);
    });

    if (isAuthenticated) {
        fetchOrders();
    }
</script>
@endsection