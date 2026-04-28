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
        <p>Masukkan nomor WhatsApp untuk melihat riwayat pesanan.</p>
    </div>

    <div class="card shadow-sm" style="max-width: 500px; margin-bottom: 30px;">
        <div class="search-box-wa">
            <input type="text" id="waSearch" placeholder="Nomor WhatsApp (Contoh: 0812...)" class="form-control">
            <button class="btn btn-accent" onclick="searchOrders()">Cari Pesanan</button>
        </div>
    </div>

    <div id="orderList" class="order-grid">
        <div class="empty-state">
            <i class="fas fa-search fa-3x"></i>
            <p>Silakan cari berdasarkan nomor WhatsApp Anda.</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function searchOrders() {
        const wa = document.getElementById('waSearch').value;
        if (!wa) {
            alert('Masukkan nomor WhatsApp Anda.');
            return;
        }

        // Ambil data dari shared localStorage (Sinkron dengan Admin)
        const allOrders = JSON.parse(localStorage.getItem('konfirmasiPesanan')) || [];
        const myOrders = allOrders.filter(o => o.wa === wa);

        const container = document.getElementById('orderList');
        
        if (myOrders.length === 0) {
            container.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-times-circle fa-3x"></i>
                    <p>Pesanan tidak ditemukan untuk nomor ini.</p>
                </div>`;
            return;
        }

        container.innerHTML = myOrders.map(o => `
            <div class="card order-card shadow-sm">
                <div class="order-card-header">
                    <span class="order-kode">${o.kode}</span>
                    <span class="status-tag status-${o.status.toLowerCase().replace(/\s/g, '-')}">${o.status}</span>
                </div>
                <div class="order-card-body">
                    <p><i class="fas fa-calendar"></i> ${o.waktu}</p>
                    <p><i class="fas fa-money-bill-wave"></i> Total: <strong>Rp ${o.total.toLocaleString()}</strong></p>
                    <p><i class="fas fa-credit-card"></i> Metode: ${o.metode || 'Bayar di Toko'}</p>
                </div>
            </div>
        `).join('');
    }
</script>
@endsection