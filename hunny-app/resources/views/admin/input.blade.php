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
        <form id="inventarisForm" action="{{ route('admin.produk.store') }}" method="POST" class="form-grid card-body">
            @csrf
            <div class="form-group">
                <label>Kode Barang</label>
                <input type="text" name="kode_barang" class="form-control" placeholder="Contoh: FOOD-001">
            </div>
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan nama barang" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control" required>
                    <option value="Makanan">Makanan</option>
                    <option value="Aksesoris">Aksesoris</option>
                    <option value="Kesehatan">Kesehatan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah Stok</label>
                <input type="number" name="jumlah" class="form-control" min="0" required>
            </div>
            <div class="form-group">
                <label>Satuan</label>
                <input type="text" name="satuan" class="form-control" placeholder="Pcs / Kg / Botol" required>
            </div>
            <div class="form-group">
                <label>Harga Beli (Rp)</label>
                <input type="number" name="harga_beli" class="form-control" min="0" step="100" value="0" required>
            </div>
            <div class="form-group">
                <label>Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label>Supplier</label>
                <select name="supplier_id" class="form-control">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $s)
                        <option value="{{ $s->id }}">{{ $s->nama_supplier }} ({{ $s->kontak }})</option>
                    @endforeach
                </select>
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
    // basic client validation could go here
</script>
@endsection