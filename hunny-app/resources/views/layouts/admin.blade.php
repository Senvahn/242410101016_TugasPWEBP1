<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Hunny Pet Care</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="dash-layout">
        <aside class="sidebar" id="sidebar">
            <a href="{{ url('/') }}" class="sidebar-brand">
                <img src="{{ asset('logohunny.webp') }}" alt="Logo Hunny">
                <div class="sidebar-brand-text">
                    <span class="brand-name">Hunny Pet Care</span>
                    <span class="brand-sub">Admin Panel</span>
                </div>
            </a>
            <nav class="sidebar-nav">
                <span class="nav-label">Menu Utama</span>
                <a href="{{ url('/admin/input') }}" class="nav-item {{ request()->is('admin/input') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-plus-circle"></i> Input Inventaris
                </a>
                <a href="{{ url('/admin/reservasi') }}" class="nav-item {{ request()->is('admin/reservasi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-calendar-alt"></i> Reservasi
                </a>
                <a href="{{ url('/admin/stok') }}" class="nav-item {{ request()->is('admin/stok') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-boxes"></i> Stok Barang
                </a>
                <a href="{{ url('/admin/konfirmasi') }}" class="nav-item {{ request()->is('admin/konfirmasi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-clipboard-check"></i> Konfirmasi Pesanan
                </a>
            </nav>
        </aside>

        <div class="main-content">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('app.js') }}"></script>
    @yield('scripts')
</body>
</html>