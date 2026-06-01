<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hunny Pet Care</title>
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- NAV -->
<nav class="home-nav" id="homeNav">
  <a href="{{ route('beranda') }}" class="nav-brand">
    <img src="{{ asset('logohunny.webp') }}" alt="Hunny Logo">
    <div>
      <span class="nav-brand-name">Hunny Pet Care</span>
      <span class="nav-brand-subtitle">Solusi Perawatan Hewan Peliharaan</span>
    </div>
  </a>

  <div class="nav-links">
    @guest
      <a href="{{ route('register') }}" class="nav-link-customer">Daftar</a>
      <a href="{{ route('login') }}" class="nav-link-admin">Masuk</a>
    @else
      <span class="user-badge">{{ Auth::user()->name }}</span>
      <a href="{{ route('profile.edit') }}" class="nav-link-customer">Profil</a>
      <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
        @csrf
        <button type="submit" class="nav-link-logout">Keluar</button>
      </form>
    @endguest
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-pattern"></div>
  <div class="hero-decorative"></div>
  <div class="hero-logo-display">
    <img src="{{ asset('logohunny.webp') }}" alt="Hunny Logo">
  </div>

  <div class="hero-content">
    <span class="hero-eyebrow"><i class="fas fa-paw"></i> Hunny untuk Customer</span>
    <h1 class="hero-title">Beli produk dan reservasi anabul<br>dengan mudah, cepat, dan terpercaya</h1>
    <p class="hero-desc">Temukan produk perawatan hewan, pesan layanan grooming, dan jaga kesehatan anabul Anda dengan sistem yang aman dan mudah digunakan.</p>

    <div class="hero-actions">
      @guest
        <a href="{{ route('register') }}" class="btn-hero-primary">Daftar Sekarang</a>
        <a href="{{ route('login') }}" class="btn-hero-secondary">Masuk</a>
      @else
        <a href="{{ route('landing-page') }}" class="btn-hero-primary"><i class="fas fa-compass"></i> Jelajahi Hunny</a>
      @endguest
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="features-section">
  <div class="features-header">
    <span class="section-label">Keunggulan Hunny</span>
    <h2 class="section-title">Hunny Untuk Anabul Kesayangan</h2>
  </div>

  <div class="features-grid">
    <article class="feature-card">
      <span class="feature-icon"><i class="fas fa-shopping-bag"></i></span>
      <h3>Beli Produk Mudah</h3>
      <p>Temukan dan pesan produk perawatan hewan secara online dengan proses yang sederhana.</p>
    </article>
    <article class="feature-card">
      <span class="feature-icon"><i class="fas fa-calendar-check"></i></span>
      <h3>Reservasi Anabul</h3>
      <p>Pesan layanan grooming dan kesehatan hewan peliharaan tanpa repot, langsung dari ponsel Anda.</p>
    </article>
    <article class="feature-card">
      <span class="feature-icon"><i class="fas fa-shield-alt"></i></span>
      <h3>Terpercaya</h3>
      <p>Layanan dan produk hunny dirancang untuk memberikan pengalaman yang aman dan dapat diandalkan.</p>
    </article>
    <article class="feature-card">
      <span class="feature-icon"><i class="fas fa-heartbeat"></i></span>
      <h3>Kesehatan Anabul Terjamin</h3>
      <p>Fokus pada kesejahteraan hewan peliharaan dengan pilihan produk dan layanan yang mendukung kesehatan.</p>
    </article>
  </div>
</section>

<!-- FOOTER -->
<footer class="home-footer">
  <p>&copy; 2024 Hunny Pet Care. Semua hak dilindungi.</p>
</footer>

<script>
  const nav = document.getElementById('homeNav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 40);
  });
</script>
<script src="{{ asset('app.js') }}"></script>
</body>
</html>
