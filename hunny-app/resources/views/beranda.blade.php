<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hunny Pet Care</title>
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .weather-widget {
      max-width: 320px;
      margin: 30px auto 0;
      background: white;
      border: 1px solid rgba(0,0,0,0.08);
      border-radius: 20px;
      box-shadow: 0 16px 40px rgba(0,0,0,0.05);
      padding: 24px;
      text-align: center;
    }
    .weather-widget h3 {
      margin: 0 0 8px;
      font-size: 1.1rem;
      color: #333;
    }
    .weather-widget .weather-temp {
      font-size: 2.2rem;
      font-weight: 700;
      color: #0d4f8b;
      margin: 8px 0;
    }
    .weather-widget .weather-desc {
      margin: 0;
      color: #6b7280;
      font-size: 0.95rem;
    }
    .weather-widget .weather-loading {
      color: #9ca3af;
      font-size: 0.95rem;
      margin-top: 12px;
    }
  </style>
</head>
<body>

<!-- NAV -->
<nav class="home-nav" id="homeNav">
  <a href="{{ route('beranda') }}" class="nav-brand">
    <img src="logohunny.webp" alt="Hunny Logo">
    <span class="nav-brand-name">Hunny Pet Care</span>
  </a>
  <div class="nav-links">
    <a href="{{ url('/customer') }}" class="nav-link-customer">Customer Portal</a>
    <a href="{{ url('/admin/input') }}" class="nav-link-admin">Admin Portal</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-pattern"></div>
  <div class="hero-decorative">
    <div class="hero-logo-display">
      <img src="{{ asset('logohunny.webp') }}" alt="Logo">
    </div>
  </div>
  <div class="hero-content">
    <div class="hero-eyebrow">
      <i class="fas fa-paw"></i>
      Professional Pet Services
    </div>
    <h1 class="hero-title">
      Kasih Sayang Terbaik<br>
      Untuk <span class="text-accent">Anabul</span> Anda
    </h1>
    <p class="hero-desc">
      Solusi manajemen perawatan hewan peliharaan terlengkap, mulai dari reservasi grooming hingga pengelolaan stok perlengkapan terbaik.
    </p>
    <div class="hero-actions">
      <a href="{{ url('/admin/input') }}" class="btn-hero-primary">
        <i class="fas fa-th-large"></i>
        Buka Dashboard
      </a>
      <a href="{{ url('/customer') }}" class="btn-hero-secondary" style="text-decoration:none;">
        Portal Customer <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>
</section>

<!-- STATS STRIP -->
<div class="stats-strip">
  <div class="strip-stat">
    <div class="strip-icon"><i class="fas fa-paw"></i></div>
    <div class="strip-text">
      <h3>500+</h3>
      <p>Anabul Terawat</p>
    </div>
  </div>
  <div class="strip-stat">
    <div class="strip-icon"><i class="fas fa-star"></i></div>
    <div class="strip-text">
      <h3>4.8/5</h3>
      <p>Rating Kepuasan</p>
    </div>
  </div>
  <div class="strip-stat">
    <div class="strip-icon"><i class="fas fa-shield-alt"></i></div>
    <div class="strip-text">
      <h3>100%</h3>
      <p>Layanan Aman & Terpercaya</p>
    </div>
  </div>
</div>

<!-- WEATHER WIDGET -->
<section class="weather-widget" aria-label="Cuaca Surabaya">
  <h3>Cuaca Surabaya</h3>
  <div id="weatherContent">
    <div class="weather-loading">Memuat data cuaca...</div>
  </div>
</section>

<!-- FEATURES -->
<section class="features-section">
  <div class="section-label">Layanan Kami</div>
  <h2 class="section-title">Semua Kebutuhan Anabul<br>Dalam Satu Platform</h2>
  <p class="section-desc">Dari grooming profesional hingga manajemen stok perlengkapan, kami hadir untuk memastikan anabul Anda mendapat perawatan terbaik.</p>

  <div class="features-grid">
    <div class="feature-card fade-in">
      <div class="feature-icon"><i class="fas fa-cut"></i></div>
      <h3>Grooming & Spa</h3>
      <p>Layanan grooming profesional dengan berbagai paket, mulai dari mandi dasar hingga spa premium untuk anabul kesayangan Anda.</p>
    </div>
    <div class="feature-card fade-in fade-in-delay-1">
      <div class="feature-icon"><i class="fas fa-calendar-check"></i></div>
      <h3>Sistem Reservasi</h3>
      <p>Kelola jadwal dan antrean reservasi grooming secara efisien. Lacak setiap janji layanan dengan mudah dan terorganisir.</p>
    </div>
    <div class="feature-card fade-in fade-in-delay-2">
      <div class="feature-icon"><i class="fas fa-boxes"></i></div>
      <h3>Manajemen Inventaris</h3>
      <p>Pantau stok perlengkapan perawatan secara real-time. Input barang baru dan kelola kategori dengan antarmuka yang intuitif.</p>
    </div>
    <div class="feature-card fade-in fade-in-delay-3">
      <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
      <h3>Laporan & Statistik</h3>
      <p>Dapatkan insight mendalam tentang performa bisnis melalui dashboard statistik yang informatif dan mudah dipahami.</p>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="home-footer">
  <span>&copy; 2024 <strong>Hunny Pet Care</strong>. Hak Cipta Dilindungi.</span>
  <span>Dibuat dengan <i class="fas fa-heart" style="color:var(--accent)"></i> untuk para pecinta anabul</span>
</footer>

<script>
  const nav = document.getElementById('homeNav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 50);
  });
  nav.classList.add('scrolled'); // always show nav bg

  async function fetchWeather() {
    const container = document.getElementById('weatherContent');
    container.innerHTML = '<div class="weather-loading">Memuat data cuaca...</div>';

    try {
      const response = await fetch('https://wttr.in/Surabaya?format=j1');
      if (!response.ok) {
        throw new Error('Gagal mengambil data cuaca');
      }
      const data = await response.json();
      const city = 'Surabaya';
      const tempC = data.current_condition?.[0]?.temp_C ?? '-';
      const description = data.current_condition?.[0]?.weatherDesc?.[0]?.value ?? 'Tidak tersedia';

      container.innerHTML = `
        <div class="weather-temp">${tempC}°C</div>
        <p class="weather-desc">${description}</p>
        <p class="weather-desc">Kota: ${city}</p>
      `;
    } catch (error) {
      container.innerHTML = `<div class="weather-loading">Tidak dapat memuat cuaca saat ini.</div>`;
      console.error('Weather fetch error:', error);
    }
  }

  fetchWeather();
</script>
<script src="{{ asset('app.js') }}"></script>
</body>
</html>
