@extends('layouts.admin')

@section('title', 'Input Inventaris')

@section('content')
<div class="topbar">
    <div class="topbar-left">
        <h1 class="page-title">Input Inventaris Baru</h1>
        <p class="page-subtitle">Tambahkan stok perlengkapan anabul ke dalam sistem</p>
    </div>
</div>

<div class="page-content">
    <div class="card shadow-sm">
        <form id="inventarisForm" class="grid-form">
            <div class="form-group">
                <label>Kode Barang</label>
                <input type="text" name="kode" placeholder="Contoh: FOOD-001" required>
            </div>
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama" placeholder="Masukkan nama barang" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" required>
                    <option value="Makanan">Makanan</option>
                    <option value="Aksesoris">Aksesoris</option>
                    <option value="Kesehatan">Kesehatan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah Stok</label>
                <input type="number" name="jumlah" min="1" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-accent">Simpan Barang</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('inventarisForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Data berhasil disimpan ke sistem (Local Storage)');
    });
</script>
@endsection