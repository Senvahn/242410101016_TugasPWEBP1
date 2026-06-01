<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan - Hunny Pet Care</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a2b3c;
            --accent: #c9894a;
            --accent-light: #e8b07a;
            --cream: #faf7f2;
            --cream-dark: #f0ebe1;
            --white: #ffffff;
            --text: #2d3748;
            --text-muted: #718096;
            --border: #e2d9cc;
            --success: #38a169;
            --danger: #e53e3e;
            --warning: #d69e2e;
            --info: #3182ce;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow: 0 4px 24px rgba(26,43,60,0.08);
            --shadow-lg: 0 12px 48px rgba(26,43,60,0.14);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--text);
            line-height: 1.6;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--cream-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 99px;
        }

        /* ============ HEADER ============ */
        .header {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 20px 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }

        .header-brand img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--accent);
            object-fit: cover;
        }

        .header-brand-text h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            color: var(--primary);
            font-weight: 700;
            line-height: 1.2;
        }

        .header-brand-text p {
            font-size: 0.65rem;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        .header-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: var(--text);
        }

        .header-info strong {
            color: var(--primary);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-btn {
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .header-btn-profile {
            color: var(--primary);
            background: var(--cream-dark);
            border: 1px solid var(--border);
        }

        .header-btn-profile:hover {
            background: var(--border);
        }

        .header-btn-logout {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            color: white;
        }

        .header-btn-logout:hover {
            box-shadow: 0 4px 12px rgba(201,137,74,0.3);
            transform: translateY(-2px);
        }

        /* ============ MAIN CONTENT ============ */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px;
        }

        .page-header {
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 8px;
            font-weight: 700;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        /* ============ STATS GRID ============ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent-light);
        }

        .stat-card-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            margin-bottom: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-card-label {
            font-weight: 600;
            color: var(--primary);
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .stat-card-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* ============ SECTION TITLE ============ */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 24px;
            font-weight: 600;
        }

        /* ============ FEATURE CARDS GRID ============ */
        .feature-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .feature-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 28px;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            opacity: 0;
            transition: var(--transition);
        }

        .feature-card:hover {
            box-shadow: var(--shadow-lg);
            border-color: var(--accent-light);
            transform: translateY(-4px);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .feature-badge {
            background: var(--cream-dark);
            color: var(--text-muted);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .feature-card-content {
            flex: 1;
            margin-bottom: 20px;
        }

        .feature-card-content h3 {
            font-size: 1.1rem;
            color: var(--primary);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .feature-card-content p {
            font-size: 0.875rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .feature-card-footer {
            display: flex;
            align-items: center;
        }

        .btn-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--accent);
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .feature-card:hover .btn-link {
            gap: 12px;
            color: var(--primary);
        }

        /* ============ FOOTER ============ */
        .footer {
            background: var(--primary);
            color: rgba(255,255,255,0.6);
            padding: 32px;
            text-align: center;
            margin-top: 40px;
            font-size: 0.875rem;
        }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 768px) {
            .header-container {
                flex-wrap: wrap;
                gap: 16px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .feature-cards-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            }

            .container {
                padding: 20px;
            }

            .header {
                padding: 16px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="header">
        <div class="header-container">
            <div class="header-left">
                <a href="{{ route('beranda') }}" class="header-brand">
                    <img src="{{ asset('logohunny.webp') }}" alt="Hunny Logo">
                    <div class="header-brand-text">
                        <h2>Hunny Pet Care</h2>
                        <p>Dashboard Pelanggan</p>
                    </div>
                </a>
            </div>
            <div class="header-right">
                <div class="header-info">
                    <i class="fas fa-user-circle" style="color: var(--accent); font-size: 1.2rem;"></i>
                    <div>
                        Halo, <strong>{{ $user->name }}</strong>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="header-btn header-btn-profile">
                    <i class="fas fa-user"></i> Profil
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="header-btn header-btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <div class="container">
        <!-- PAGE HEADER -->
        <div class="page-header">
            <h1>Selamat Datang di Hunny Pet Care</h1>
            <p>Kelola pesanan Anda, pesan layanan grooming, dan jelajahi produk perawatan hewan favorit</p>
        </div>

        <!-- STATS OVERVIEW -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #3182ce, #2c5aa0);">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="stat-card-label">Belanja Produk</div>
                <div class="stat-card-desc">Jelajahi koleksi produk kami</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #38a169, #2d6a4f);">
                    <i class="fas fa-spa"></i>
                </div>
                <div class="stat-card-label">Booking Grooming</div>
                <div class="stat-card-desc">Pesan jasa grooming profesional</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #d69e2e, #b7791f);">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="stat-card-label">Pesanan Saya</div>
                <div class="stat-card-desc">Lihat riwayat pembelian</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-icon" style="background: linear-gradient(135deg, #c9894a, #9f6e38);">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="stat-card-label">Reservasi Saya</div>
                <div class="stat-card-desc">Kelola jadwal grooming Anda</div>
            </div>
        </div>

        <!-- FEATURED SERVICES -->
        <h2 class="section-title">Layanan Unggulan</h2>
        <div class="feature-cards-grid">
            <!-- Belanja Produk -->
            <a href="{{ route('shop.index') }}" class="feature-card">
                <div class="feature-card-header">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #3182ce, #2c5aa0);">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <span class="feature-badge">Store</span>
                </div>
                <div class="feature-card-content">
                    <h3>Belanja Produk</h3>
                    <p>Jelajahi koleksi lengkap produk perawatan hewan peliharaan berkualitas tinggi dengan harga terjangkau.</p>
                </div>
                <div class="feature-card-footer">
                    <span class="btn-link">Mulai Belanja <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- Booking Grooming -->
            <a href="{{ route('booking.create') }}" class="feature-card">
                <div class="feature-card-header">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #38a169, #2d6a4f);">
                        <i class="fas fa-spa"></i>
                    </div>
                    <span class="feature-badge">Services</span>
                </div>
                <div class="feature-card-content">
                    <h3>Booking Jasa Grooming</h3>
                    <p>Pesan layanan grooming profesional untuk hewan kesayangan Anda dengan jadwal yang fleksibel.</p>
                </div>
                <div class="feature-card-footer">
                    <span class="btn-link">Pesan Grooming <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- Pesanan Saya -->
            <a href="{{ route('pesanan.saya') }}" class="feature-card">
                <div class="feature-card-header">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #d69e2e, #b7791f);">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <span class="feature-badge">Orders</span>
                </div>
                <div class="feature-card-content">
                    <h3>Pesanan Saya</h3>
                    <p>Lihat riwayat, detail, dan status pesanan barang Anda serta kelola pengiriman dengan mudah.</p>
                </div>
                <div class="feature-card-footer">
                    <span class="btn-link">Lihat Pesanan <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- Reservasi Saya -->
            <a href="{{ route('booking.index') }}" class="feature-card">
                <div class="feature-card-header">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #c9894a, #9f6e38);">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <span class="feature-badge">Schedule</span>
                </div>
                <div class="feature-card-content">
                    <h3>Reservasi Saya</h3>
                    <p>Kelola reservasi grooming Anda, lihat jadwal, dan lakukan pembatalan jika diperlukan.</p>
                </div>
                <div class="feature-card-footer">
                    <span class="btn-link">Lihat Reservasi <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>

            <!-- Jelajahi Layanan (removed) -->

            <!-- Kembali ke Beranda -->
            <a href="{{ route('beranda') }}" class="feature-card">
                <div class="feature-card-header">
                    <div class="feature-icon" style="background: linear-gradient(135deg, #4c5f7d, #3d4f63);">
                        <i class="fas fa-home"></i>
                    </div>
                    <span class="feature-badge">Website</span>
                </div>
                <div class="feature-card-content">
                    <h3>Kembali ke Beranda</h3>
                    <p>Kembali ke halaman utama website Hunny Pet Care untuk melihat informasi lengkap perusahaan.</p>
                </div>
                <div class="feature-card-footer">
                    <span class="btn-link">Ke Beranda <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; 2024 Hunny Pet Care. Semua hak dilindungi. Kasih sayang terbaik untuk anabul Anda.</p>
    </footer>
</body>
</html>
