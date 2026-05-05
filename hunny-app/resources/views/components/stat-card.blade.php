{{--
    Komponen stat-card
    Props:
      - $judul : string (judul/label kartu)
      - $nilai : string|int (nilai statistik)
      - $ikon  : string (kelas icon Font Awesome, contoh: 'fas fa-users')
      - $warna : string (warna tema: 'orange' | 'blue' | 'green' | 'red' | 'purple')
--}}
@props([
    'judul' => 'Judul',
    'nilai' => 0,
    'ikon'  => 'fas fa-chart-line',
    'warna' => 'orange',
])

<div {{ $attributes->merge(['class' => 'stat-card']) }}>
    <div class="stat-icon {{ $warna }}">
        <i class="{{ $ikon }}"></i>
    </div>
    <div class="stat-value">{{ $nilai }}</div>
    <div class="stat-label">{{ $judul }}</div>
</div>