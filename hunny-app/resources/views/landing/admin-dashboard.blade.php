@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container">
    <!-- STATS OVERVIEW -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #3182ce, #2c5aa0);">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-card-label">Manajemen Stok</div>
            <div class="stat-card-desc">Kelola inventaris produk</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #38a169, #2d6a4f);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-card-label">Konfirmasi Pesanan</div>
            <div class="stat-card-desc">Proses pesanan pelanggan</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #d69e2e, #b7791f);">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-card-label">Manajemen Reservasi</div>
            <div class="stat-card-desc">Kelola jadwal grooming</div>
        </div>
    </div>

    <!-- FEATURE CARDS GRID -->
    <div class="features-section">
        <h2 class="section-title">Fitur Manajemen</h2>
        
        <div class="feature-cards-grid">
            <!-- Kelola Stok Barang -->
            <a href="{{ route('admin.stok') }}" class="feature-card feature-card-hover">
                <div class="feature-card-header">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #3182ce, #2c5aa0);">
                        <i class="fas fa-cube"></i>
                    </div>
                    <span class="feature-badge">Inventory</span>
                </div>
                <div class="feature-card-content">
                    <h3>Kelola Stok Barang</h3>
                    <p>Tambah, ubah, atau hapus produk dari inventaris toko Anda dengan mudah dan cepat.</p>
                </div>
                <div class="feature-card-footer">
                    <span class="btn-link">Buka Manajemen <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- Konfirmasi Pesanan -->
            <a href="{{ route('admin.konfirmasi') }}" class="feature-card feature-card-hover">
                <div class="feature-card-header">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #38a169, #2d6a4f);">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <span class="feature-badge">Orders</span>
                </div>
                <div class="feature-card-content">
                    <h3>Konfirmasi Pesanan</h3>
                    <p>Proses dan konfirmasi pesanan dari pelanggan Anda secara real-time dan terorganisir.</p>
                </div>
                <div class="feature-card-footer">
                    <span class="btn-link">Lihat Pesanan <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- Kelola Reservasi (quick services management) -->
            <a href="{{ route('admin.services.index') }}" class="feature-card feature-card-hover">
                <div class="feature-card-header">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #c9894a, #b8860b);">
                        <i class="fas fa-tools"></i>
                    </div>
                    <span class="feature-badge">Admin</span>
                </div>
                <div class="feature-card-content">
                    <h3>Kelola Reservasi</h3>
                    <p>Tambah atau ubah layanan dan harga yang dapat dipilih pelanggan saat reservasi.</p>
                </div>
                <div class="feature-card-footer">
                    <span class="btn-link">Kelola Reservasi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- Manajemen Reservasi -->
            <a href="{{ route('admin.reservasi') }}" class="feature-card feature-card-hover">
                <div class="feature-card-header">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #d69e2e, #b7791f);">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <span class="feature-badge">Schedule</span>
                </div>
                <div class="feature-card-content">
                    <h3>Manajemen Reservasi</h3>
                    <p>Kelola reservasi grooming dan jasa perawatan hewan dengan sistem booking yang efisien.</p>
                </div>
                <div class="feature-card-footer">
                    <span class="btn-link">Kelola Reservasi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- Kembali ke Beranda -->
            <a href="{{ route('beranda') }}" class="feature-card">
                <div class="feature-card-header">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #c9894a, #9f6e38);">
                        <i class="fas fa-home"></i>
                    </div>
                    <span class="feature-badge">Public</span>
                </div>
                <div class="feature-card-content">
                    <h3>Kembali ke Beranda</h3>
                    <p>Lihat halaman utama website Hunny Pet Care untuk melihat tampilan publik aplikasi.</p>
                </div>
                <div class="feature-card-footer">
                    <span class="btn-link">Ke Beranda <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection
