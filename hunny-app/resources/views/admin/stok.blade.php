@extends('layouts.admin')

@section('title', 'Stok Barang')

@section('content')
<div class="topbar">
    <div class="topbar-left">
        <h1 class="page-title">Manajemen Stok</h1>
        <p class="page-subtitle">Pantau dan kelola ketersediaan perlengkapan anabul</p>
    </div>
    <div class="topbar-right">
        <a href="{{ url('/admin/input') }}" class="btn btn-accent">
            <i class="fas fa-plus"></i> Tambah Barang
        </a>
    </div>
</div>

<div class="page-content">
    <div class="stats-grid" style="margin-bottom: 24px;">
        <div class="stat-card">
            <span class="stat-label">Total Jenis Barang</span>
            <span class="stat-value" id="totalJenis">0</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Stok Tipis (< 5)</span>
            <span class="stat-value" id="lowStock" style="color:var(--danger)">0</span>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="stokTableBody">
                    </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const DATA_KEY = 'stokBarang';

    function renderTable() {
        const data = JSON.parse(localStorage.getItem(DATA_KEY)) || [];
        const tbody = document.getElementById('stokTableBody');
        
        tbody.innerHTML = data.map((b, index) => `
            <tr>
                <td><strong>${b.kode}</strong></td>
                <td>${b.nama}</td>
                <td><span class="status-tag info">${b.kategori}</span></td>
                <td><strong style="color: ${parseInt(b.jumlah) < 5 ? 'var(--danger)' : 'inherit'}">${b.jumlah}</strong></td>
                <td>Rp ${parseInt(b.harga).toLocaleString()}</td>
                <td>
                    <button class="btn-icon" onclick="deleteBarang(${index})"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `).join('');

        document.getElementById('totalJenis').textContent = data.length;
        document.getElementById('lowStock').textContent = data.filter(b => parseInt(b.jumlah) < 5).length;
    }

    function deleteBarang(index) {
        if(confirm('Hapus barang ini dari stok?')) {
            let data = JSON.parse(localStorage.getItem(DATA_KEY)) || [];
            data.splice(index, 1);
            localStorage.setItem(DATA_KEY, JSON.stringify(data));
            renderTable();
        }
    }

    window.onload = renderTable;
</script>
@endsection