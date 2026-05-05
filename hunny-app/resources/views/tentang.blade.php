@extends('layouts.app')

@section('title', 'Tentang Kami')

@push('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, #1a2b3c 0%, #243b52 100%);
        color: #fff; padding: 56px 40px; text-align: center;
    }
    .about-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 3.2vw, 2.4rem);
        margin-bottom: 10px;
    }
    .about-hero p { color: rgba(255,255,255,0.7); max-width: 620px; margin: 0 auto; }

    .about-body {
        max-width: 1000px; margin: 0 auto;
        padding: 40px 32px;
    }
    .about-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-top: 24px;
    }
    .about-card {
        background: #fff;
        border: 1px solid #e2d9cc;
        border-radius: 12px;
        padding: 24px;
        transition: all 0.25s ease;
    }
    .about-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(26,43,60,0.1);
        border-color: rgba(201,137,74,0.3);
    }
    .about-card .ic {
        width: 48px; height: 48px; border-radius: 10px;
        background: rgba(201,137,74,0.12);
        color: #c9894a;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; margin-bottom: 14px;
    }
    .about-card h3 {
        font-family: 'Playfair Display', serif;
        color: #1a2b3c; font-size: 1.05rem; margin-bottom: 6px;
    }
    .about-card p { color: #718096; font-size: 0.875rem; line-height: 1.7; }

    .about-text {
        background: #fff;
        border: 1px solid #e2d9cc;
        border-radius: 12px;
        padding: 28px;
    }
    .about-text h2 {
        font-family: 'Playfair Display', serif;
        color: #1a2b3c; font-size: 1.3rem; margin-bottom: 12px;
    }
    .about-text p {
        color: #4a5568; font-size: 0.95rem; line-height: 1.8;
        margin-bottom: 12px;
    }
</style>
@endpush

@section('content')
<section class="about-hero">
    <h1>Tentang Hunny Pet Care</h1>
    <p>Platform manajemen layanan hewan peliharaan yang menggabungkan kenyamanan, kualitas, dan kepedulian untuk setiap anabul.</p>
</section>

<div class="about-body">
    <div class="about-text">
        <h2>Kisah Kami</h2>
        <p>
            Hunny Pet Care lahir dari kecintaan terhadap hewan peliharaan dan komitmen untuk memberikan
            perawatan terbaik. Kami menghadirkan solusi terintegrasi mulai dari reservasi grooming,
            manajemen stok perlengkapan, hingga layanan konsumen yang responsif.
        </p>
        <p>
            Dengan tim berpengalaman dan teknologi modern, kami membantu pemilik anabul menikmati
            pengalaman perawatan yang mudah, cepat, dan aman.
        </p>
    </div>

    <div class="about-grid">
        <div class="about-card">
            <div class="ic"><i class="fas fa-bullseye"></i></div>
            <h3>Misi</h3>
            <p>Memberikan layanan perawatan anabul yang profesional, higienis, dan terjangkau untuk semua kalangan.</p>
        </div>
        <div class="about-card">
            <div class="ic"><i class="fas fa-eye"></i></div>
            <h3>Visi</h3>
            <p>Menjadi platform pet care terdepan di Indonesia dengan standar pelayanan internasional.</p>
        </div>
        <div class="about-card">
            <div class="ic"><i class="fas fa-heart"></i></div>
            <h3>Nilai Kami</h3>
            <p>Kasih sayang, integritas, dan profesionalisme dalam setiap interaksi dengan anabul dan pemiliknya.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script spesifik halaman Tentang
    console.log('[Tentang] Halaman Tentang dimuat.');
</script>
@endpush