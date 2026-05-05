@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .dashboard-head {
        background: linear-gradient(135deg, #1a2b3c 0%, #243b52 100%);
        color: #fff;
        padding: 48px 40px;
        position: relative; overflow: hidden;
    }
    .dashboard-head::before {
        content: ''; position: absolute;
        right: -60px; top: -60px;
        width: 260px; height: 260px;
        border-radius: 50%;
        border: 1px solid rgba(201,137,74,0.2);
    }
    .dashboard-head h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.6rem, 3vw, 2.2rem);
        margin-bottom: 8px;
    }
    .dashboard-head p {
        color: rgba(255,255,255,0.65);
        font-size: 0.95rem;
    }
    .dashboard-body {
        max-width: 1280px; margin: 0 auto;
        padding: 32px 40px;
    }
    .section-title-dash {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem; color: #1a2b3c;
        margin-bottom: 16px; font-weight: 700;
    }
    .dash-empty {
        background: #fff;
        border: 1px dashed #e2d9cc;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        color: #718096;
    }
    .recent-list {
        background: #fff;
        border: 1px solid #e2d9cc;
        border-radius: 12px;
        padding: 8px;
    }
    .recent-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 16px; border-radius: 8px;
        transition: background 0.2s ease;
    }
    .recent-item:hover { background: #faf7f2; }
    .recent-item + .recent-item { border-top: 1px solid #f0ebe1; }
    .recent-item-left {
        display: flex; align-items: center; gap: 12px;
    }
    .recent-icon {
        width: 38px; height: 38px; border-radius: 8px;
        background: rgba(201,137,74,0.12);
        color: #c9894a;
        display: flex; align-items: center; justify-content: center;
    }
    .recent-meta strong {
        display: block; color: #1a2b3c; font-size: 0.9rem;
    }
    .recent-meta small { color: #718096; font-size: 0.75rem; }
    @media (max-width: 720px) {
        .dashboard-head, .dashboard-body { padding-left: 20px; padding-right: 20px; }
    }
</style>
@endpush

@section('content')
<section class="dashboard-head">
    <h1>Selamat datang di Dashboard</h1>
    <p>Pantau aktivitas dan statistik Hunny Pet Care secara real-time.</p>
</section>

<div class="dashboard-body">

    {{-- ===== STATISTIK UTAMA ===== --}}
    <h2 class="section-title-dash">Ringkasan Statistik</h2>

    @php
        // Data dummy untuk ditampilkan dengan @forelse
        $statistik = [
            ['judul' => 'Jumlah Mahasiswa', 'nilai' => 248, 'ikon' => 'fas fa-user-graduate', 'warna' => 'blue'],
            ['judul' => 'Mata Kuliah',      'nilai' => 42,  'ikon' => 'fas fa-book',          'warna' => 'orange'],
            ['judul' => 'Dosen Aktif',      'nilai' => 18,  'ikon' => 'fas fa-chalkboard-teacher', 'warna' => 'green'],
            ['judul' => 'Kelas Berjalan',   'nilai' => 36,  'ikon' => 'fas fa-door-open',     'warna' => 'red'],
        ];

        $aktivitasTerbaru = [
            ['judul' => 'Reservasi baru dari Andi Pratama', 'waktu' => '5 menit lalu', 'ikon' => 'fas fa-calendar-check'],
            ['judul' => 'Stok Royal Canin ditambahkan (+20)', 'waktu' => '1 jam lalu', 'ikon' => 'fas fa-boxes'],
            ['judul' => 'Pesanan #HPC-0241 dikonfirmasi',   'waktu' => '2 jam lalu', 'ikon' => 'fas fa-check-circle'],
            ['judul' => 'Mahasiswa baru terdaftar: Sinta W.','waktu' => '4 jam lalu', 'ikon' => 'fas fa-user-plus'],
        ];
    @endphp

    <div class="stats-grid">
        @forelse ($statistik as $item)
            <x-stat-card
                :judul="$item['judul']"
                :nilai="$item['nilai']"
                :ikon="$item['ikon']"
                :warna="$item['warna']"
            />
        @empty
            <div class="dash-empty">
                <i class="fas fa-inbox" style="font-size:2rem; opacity:0.3; display:block; margin-bottom:10px;"></i>
                Belum ada data statistik untuk ditampilkan.
            </div>
        @endforelse
    </div>

    {{-- ===== AKTIVITAS TERBARU ===== --}}
    <h2 class="section-title-dash" style="margin-top:32px;">Aktivitas Terbaru</h2>

    <div class="recent-list">
        @forelse ($aktivitasTerbaru as $akt)
            <div class="recent-item">
                <div class="recent-item-left">
                    <div class="recent-icon"><i class="{{ $akt['ikon'] }}"></i></div>
                    <div class="recent-meta">
                        <strong>{{ $akt['judul'] }}</strong>
                        <small>{{ $akt['waktu'] }}</small>
                    </div>
                </div>
                <i class="fas fa-chevron-right" style="color:#cbd5e0; font-size:0.8rem;"></i>
            </div>
        @empty
            <div class="dash-empty">
                <i class="fas fa-clock" style="font-size:2rem; opacity:0.3; display:block; margin-bottom:10px;"></i>
                Belum ada aktivitas terbaru.
            </div>
        @endforelse
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Script spesifik halaman dashboard
    console.log('[Dashboard] Loaded at', new Date().toLocaleTimeString());

    // Animasi counter stat-value saat muncul di viewport
    document.addEventListener('DOMContentLoaded', function() {
        const values = document.querySelectorAll('.stat-card .stat-value');
        values.forEach(el => {
            const target = parseInt(el.textContent, 10);
            if (isNaN(target)) return;
            let current = 0;
            const step = Math.max(1, Math.ceil(target / 40));
            const timer = setInterval(() => {
                current += step;
                if (current >= target) { current = target; clearInterval(timer); }
                el.textContent = current;
            }, 25);
        });
    });
</script>
@endpush