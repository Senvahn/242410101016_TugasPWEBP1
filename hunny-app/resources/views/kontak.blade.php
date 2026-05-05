@extends('layouts.app')

@section('title', 'Kontak')

@push('styles')
<style>
    .contact-hero {
        background: linear-gradient(135deg, #1a2b3c 0%, #243b52 100%);
        color: #fff; padding: 56px 40px; text-align: center;
    }
    .contact-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 3.2vw, 2.4rem); margin-bottom: 10px;
    }
    .contact-hero p { color: rgba(255,255,255,0.7); max-width: 620px; margin: 0 auto; }

    .contact-body {
        max-width: 1100px; margin: 0 auto;
        padding: 40px 32px;
        display: grid; grid-template-columns: 1fr 1.3fr;
        gap: 28px;
    }
    .contact-info, .contact-form-card {
        background: #fff;
        border: 1px solid #e2d9cc;
        border-radius: 12px;
        padding: 28px;
    }
    .contact-info h2, .contact-form-card h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem; color: #1a2b3c; margin-bottom: 18px;
    }
    .contact-row {
        display: flex; align-items: flex-start; gap: 14px;
        padding: 12px 0;
        border-bottom: 1px dashed #e2d9cc;
    }
    .contact-row:last-child { border-bottom: none; }
    .contact-row .ic {
        width: 38px; height: 38px; border-radius: 8px;
        background: rgba(201,137,74,0.12);
        color: #c9894a;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .contact-row strong { color: #1a2b3c; font-size: 0.875rem; display: block; }
    .contact-row span { color: #718096; font-size: 0.82rem; }

    .contact-form-card label {
        display: block; font-size: 0.82rem; font-weight: 600;
        color: #1a2b3c; margin-bottom: 6px;
    }
    .contact-form-card input,
    .contact-form-card textarea {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #e2d9cc;
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem;
        margin-bottom: 16px;
        background: #faf7f2;
        outline: none; transition: all 0.25s ease;
    }
    .contact-form-card input:focus,
    .contact-form-card textarea:focus {
        border-color: #c9894a; background: #fff;
        box-shadow: 0 0 0 3px rgba(201,137,74,0.12);
    }
    .contact-form-card textarea { min-height: 120px; resize: vertical; }
    .btn-submit-kontak {
        background: linear-gradient(135deg, #c9894a, #e8b07a);
        color: #fff; border: none;
        padding: 12px 28px;
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.875rem; font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(201,137,74,0.35);
        transition: all 0.25s ease;
    }
    .btn-submit-kontak:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(201,137,74,0.45);
    }
    @media (max-width: 760px) {
        .contact-body { grid-template-columns: 1fr; padding: 28px 20px; }
    }
</style>
@endpush

@section('content')
<section class="contact-hero">
    <h1>Hubungi Kami</h1>
    <p>Punya pertanyaan atau ingin berkonsultasi? Kami siap membantu setiap kebutuhan anabul Anda.</p>
</section>

<div class="contact-body">
    <div class="contact-info">
        <h2>Informasi Kontak</h2>
        <div class="contact-row">
            <div class="ic"><i class="fas fa-map-marker-alt"></i></div>
            <div>
                <strong>Alamat</strong>
                <span>Jl. Anabul No. 24, Kota Hangat, Indonesia</span>
            </div>
        </div>
        <div class="contact-row">
            <div class="ic"><i class="fas fa-phone"></i></div>
            <div>
                <strong>Telepon</strong>
                <span>+62 812-3456-7890</span>
            </div>
        </div>
        <div class="contact-row">
            <div class="ic"><i class="fas fa-envelope"></i></div>
            <div>
                <strong>Email</strong>
                <span>halo@hunnypetcare.id</span>
            </div>
        </div>
        <div class="contact-row">
            <div class="ic"><i class="fas fa-clock"></i></div>
            <div>
                <strong>Jam Operasional</strong>
                <span>Setiap hari, 08.00 – 20.00 WIB</span>
            </div>
        </div>
    </div>

    <div class="contact-form-card">
        <h2>Kirim Pesan</h2>
        <form id="kontakForm" method="POST" action="{{ url('/kontak') }}">
            @csrf
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" placeholder="Nama Anda" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="email@contoh.com" required>

            <label for="pesan">Pesan</label>
            <textarea id="pesan" name="pesan" placeholder="Tulis pesan Anda..." required></textarea>

            <button type="submit" class="btn-submit-kontak">
                <i class="fas fa-paper-plane"></i> Kirim Pesan
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Script spesifik halaman Kontak
    document.getElementById('kontakForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const nama = document.getElementById('nama').value.trim();
        const pesan = document.getElementById('pesan').value.trim();
        if (!nama || !pesan) {
            alert('Mohon lengkapi nama dan pesan Anda.');
            return;
        }
        alert('Terima kasih, ' + nama + '! Pesan Anda telah kami terima.');
        this.reset();
    });
</script>
@endpush