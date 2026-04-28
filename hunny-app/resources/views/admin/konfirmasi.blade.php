@extends('layouts.admin')

@section('title', 'Konfirmasi Pesanan')

@section('content')
<div class="topbar">
    <div class="topbar-left">
        <h1 class="page-title">Konfirmasi Pesanan</h1>
        <p class="page-subtitle">Kelola dan validasi pesanan masuk dari pelanggan</p>
    </div>
    <div class="topbar-right">
        <button class="btn btn-outline" onclick="refreshOrders()">
            <i class="fas fa-sync-alt"></i> Refresh Data
        </button>
    </div>
</div>

<div class="page-content">
    <div class="stats-grid" style="margin-bottom: 24px;">
        <div class="stat-card">
            <span class="stat-label">Total Pesanan</span>
            <span class="stat-value" id="totalOrders">0</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Perlu Konfirmasi</span>
            <span class="stat-value" id="pendingOrders" style="color:var(--warning)">0</span>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Logic JavaScript asli dari konfirmasipesanan.html Anda
    const DATA_KEY = 'konfirmasiPesanan';
    let allOrders = JSON.parse(localStorage.getItem(DATA_KEY)) || [];

    function renderTable(data) {
        const tbody = document.getElementById('orderTableBody');
        tbody.innerHTML = data.map((o, index) => `
            <tr>
                <td>${o.waktu}</td>
                <td><strong>${o.kode}</strong></td>
                <td>${o.nama}</td>
                <td>Rp ${o.total.toLocaleString()}</td>
                <td><span class="status-tag status-${o.status.toLowerCase().replace(/\s/g, '-')}">${o.status}</span></td>
                <td>
                    <button class="btn-icon" onclick="updateStatus(${index})"><i class="fas fa-edit"></i></button>
                </td>
            </tr>
        `).join('');
        
        document.getElementById('totalOrders').textContent = data.length;
        document.getElementById('pendingOrders').textContent = data.filter(o => o.status === 'Menunggu Konfirmasi').length;
    }

    function refreshOrders() {
        allOrders = JSON.parse(localStorage.getItem(DATA_KEY)) || [];
        renderTable(allOrders);
    }

    window.onload = refreshOrders;
</script>
@endsection