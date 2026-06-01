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
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="stats-grid">
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
                        <th>Gambar</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Supplier</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $p)
                        <tr>
                            <td>
                                @if($p->foto_produk)
                                    <img src="{{ asset('storage/' . $p->foto_produk) }}" alt="{{ $p->nama_barang }}" style="width:64px; height:64px; object-fit:cover; border-radius:8px;">
                                @else
                                    <div style="width:64px; height:64px; display:flex; align-items:center; justify-content:center; background:#f3efe9; color:#7a6e5f; border-radius:8px;">No Img</div>
                                @endif
                            </td>
                            <td><strong>{{ $p->kode_barang }}</strong></td>
                            <td>{{ $p->nama_barang }}</td>
                            <td><span class="status-tag info">{{ $p->kategori }}</span></td>
                            <td><strong style="color: {{ $p->jumlah < 5 ? 'var(--danger)' : 'inherit' }}">{{ $p->jumlah }}</strong></td>
                            <td>Rp {{ number_format($p->harga_beli ?? 0,0,',','.') }}</td>
                            <td>{{ $p->supplier?->nama_supplier ?? '-' }}</td>
                            <td style="white-space:nowrap;">
                                <a href="{{ route('admin.produk.edit', $p) }}" class="btn btn-sm btn-outline">Edit</a>
                                @if($p->status_tersedia)
                                    <form action="{{ route('admin.produk.destroy', $p) }}" method="POST" style="display:inline-block; margin-left:6px;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-warning">Nonaktifkan</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.produk.restore', $p) }}" method="POST" style="display:inline-block; margin-left:6px;">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-success">Pulihkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // update stats
    document.addEventListener('DOMContentLoaded', function () {
        const total = {{ $produks->count() }};
        const low = {{ $produks->where('jumlah', '<', 5)->count() }};
        document.getElementById('totalJenis').textContent = total;
        document.getElementById('lowStock').textContent = low;
    });
</script>
@endsection