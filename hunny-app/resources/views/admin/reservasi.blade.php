@extends('layouts.admin')

@section('title', 'Manajemen Reservasi')

@section('content')
<div class="topbar">
    <div class="topbar-left">
        <h1 class="page-title">Daftar Reservasi</h1>
        <p class="page-subtitle">Pantau dan atur jadwal grooming anabul</p>
    </div>
    <div class="topbar-right">
        <button class="btn btn-accent" onclick="openModal()">
            <i class="fas fa-plus"></i> Tambah Reservasi
        </button>
    </div>
</div>

<div class="page-content">
    <div class="stats-grid" style="margin-bottom: 24px;">
        <div class="stat-card">
            <span class="stat-label">Total Reservasi</span>
            <span class="stat-value" id="totalRes">0</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Hari Ini</span>
            <span class="stat-value" id="todayRes" style="color:var(--info)">0</span>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Jadwal</th>
                        <th>Pemilik</th>
                        <th>Anabul</th>
                        <th>Paket</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="reservasiTableBody">
                    </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modalOverlay" style="display:none;">
    <div class="modal-card">
        <h3>Tambah Reservasi Manual</h3>
        <form id="reservasiForm">
            <div class="form-group">
                <label>Nama Pemilik</label>
                <input type="text" name="pemilik" required>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" required>
            </div>
            <div class="form-actions">
                <button type="button" class="btn" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-accent">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const DATA_KEY = 'pendingReservasi';

    function renderTable() {
        const data = JSON.parse(localStorage.getItem(DATA_KEY)) || [];
        const tbody = document.getElementById('reservasiTableBody');
        
        tbody.innerHTML = data.map((r, index) => `
            <tr>
                <td><strong>${r.tanggal}</strong><br><small>${r.jam || ''}</small></td>
                <td>${r.pemilik}</td>
                <td>${r.namaHewan} (${r.hewan})</td>
                <td>${r.paket}</td>
                <td><span class="status-tag status-pending">${r.status || 'Diproses'}</span></td>
                <td>
                    <button class="btn-icon" onclick="deleteRes(${index})"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        `).join('');

        document.getElementById('totalRes').textContent = data.length;
    }

    function openModal() {
        document.getElementById('modalOverlay').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('modalOverlay').style.display = 'none';
    }

    function deleteRes(index) {
        if(confirm('Hapus reservasi ini?')) {
            let data = JSON.parse(localStorage.getItem(DATA_KEY)) || [];
            data.splice(index, 1);
            localStorage.setItem(DATA_KEY, JSON.stringify(data));
            renderTable();
        }
    }

    window.onload = renderTable;
</script>
@endsection