@extends('layouts.customer')

@section('title', 'Customer Portal')

@section('content')
<section class="cust-hero">
    <div class="cust-hero-content">
        <h1>Portal Layanan & Toko</h1>
        <p>Pilih layanan grooming terbaik atau belanja kebutuhan anabul kesayangan Anda.</p>
        <div class="cust-hero-actions">
            <a href="{{ route('shop.index') }}" class="btn btn-accent">Beli Produk</a>
            <a href="{{ route('booking.create') }}" class="btn btn-outline">Buat Reservasi</a>
            <a href="{{ route('pesanan.saya') }}" class="btn btn-outline">Lihat Pesanan</a>
        </div>
    </div>
</section>

<div class="cust-container">
    <div class="section-cards">
        <a href="{{ route('shop.index') }}" class="card shadow-sm">
            <h3>Belanja Produk</h3>
            <p>Tambahkan kebutuhan anabul ke keranjang dan checkout dengan mudah.</p>
        </a>
        <a href="{{ route('booking.create') }}" class="card shadow-sm">
            <h3>Reservasi Grooming</h3>
            <p>Pesan layanan grooming untuk anabul Anda dan pilih jadwal yang diinginkan.</p>
        </a>
        <a href="{{ route('pesanan.saya') }}" class="card shadow-sm">
            <h3>Riwayat Pesanan</h3>
            <p>Lihat status pesanan dan informasi pembayaran Anda.</p>
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openCart() {
        window.location.href = '{{ route('checkout') }}';
    }
</script>
@endsection