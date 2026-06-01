@extends('layouts.admin')

@section('title', isset($produk) ? 'Edit Inventaris' : 'Input Inventaris')

@section('content')
<div class="topbar">
    <div class="topbar-left">
        <h1 class="page-title">{{ isset($produk) ? 'Edit Inventaris' : 'Input Inventaris Baru' }}</h1>
        <p class="page-subtitle">{{ isset($produk) ? 'Perbarui data stok dan foto produk.' : 'Tambahkan stok perlengkapan anabul ke dalam sistem' }}</p>
    </div>
</div>

<div class="page-content">
    <div class="card shadow-sm">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="inventarisForm" action="{{ isset($produk) ? route('admin.produk.update', $produk) : route('admin.produk.store') }}" method="POST" enctype="multipart/form-data" class="form-grid card-body">
            @csrf
            @if(isset($produk))
                @method('PUT')
            @endif

            <div class="form-group">
                <label>Kode Barang</label>
                <input type="text" name="kode_barang" class="form-control" placeholder="Contoh: FOOD-001" value="{{ old('kode_barang', $produk->kode_barang ?? '') }}">
            </div>
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan nama barang" value="{{ old('nama_barang', $produk->nama_barang ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control" required>
                    @foreach(['Makanan','Aksesoris','Kesehatan','Lainnya'] as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori', $produk->kategori ?? '') === $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah Stok</label>
                <input type="number" name="jumlah" class="form-control" min="0" value="{{ old('jumlah', $produk->jumlah ?? 0) }}" required>
            </div>
            <div class="form-group">
                <label>Satuan</label>
                <input type="text" name="satuan" class="form-control" placeholder="Pcs / Kg / Botol" value="{{ old('satuan', $produk->satuan ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Harga Beli (Rp)</label>
                <input type="number" name="harga_beli" class="form-control" min="0" step="100" value="{{ old('harga_beli', $produk->harga_beli ?? 0) }}" required>
            </div>
            <div class="form-group">
                <label>Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', isset($produk) ? $produk->tanggal_masuk->format('Y-m-d') : date('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label>Supplier</label>
                <select name="supplier_id" class="form-control">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $s)
                        <option value="{{ $s->id }}" {{ old('supplier_id', $produk->supplier_id ?? '') == $s->id ? 'selected' : '' }}>{{ $s->nama_supplier }} ({{ $s->kontak }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Foto Produk</label>
                @if(isset($produk) && $produk->foto_produk)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset('storage/' . $produk->foto_produk) }}" alt="{{ $produk->nama_barang }}" style="max-width:160px; width:100%; height:auto; border-radius:10px; object-fit:cover;">
                        <p class="text-muted text-sm" style="margin-top:6px;">Foto saat ini. Unggah file baru untuk mengganti.</p>
                    </div>
                @endif
                <input type="file" name="foto_produk" accept="image/jpg,image/jpeg,image/png" class="form-control">
                <small class="text-muted">Unggah foto produk (jpg/jpeg/png, max 2MB).</small>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-accent">{{ isset($produk) ? 'Perbarui Barang' : 'Simpan Barang' }}</button>
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