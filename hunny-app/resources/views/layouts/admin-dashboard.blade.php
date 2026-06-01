<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="dash-layout">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <a href="{{ route('beranda') }}" class="sidebar-brand">
                <img src="{{ asset('logohunny.webp') }}" alt="Logo">
                <div class="sidebar-brand-text">
                    <span class="brand-name">Hunny</span>
                    <span class="brand-sub">Admin</span>
                </div>
            </a>

            <nav class="sidebar-nav">
                <div class="nav-label">Dashboard</div>
                <a href="{{ route('admin.stok') }}" class="nav-item {{ request()->routeIs('admin.stok') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-boxes"></i> Stok Barang
                </a>
                <a href="{{ route('admin.input') }}" class="nav-item {{ request()->routeIs('admin.input') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-plus-circle"></i> Input Produk
                </a>
                <a href="{{ route('admin.konfirmasi') }}" class="nav-item {{ request()->routeIs('admin.konfirmasi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-check-circle"></i> Konfirmasi Pesanan
                </a>
                <a href="{{ route('admin.reservasi') }}" class="nav-item {{ request()->routeIs('admin.reservasi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-calendar"></i> Reservasi Grooming
                </a>

                <div class="nav-label" style="margin-top: 24px;">Akun</div>
                <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-circle"></i> Profil
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">Admin</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin-top: 12px;">
                    @csrf
                    <button type="submit" class="nav-item" style="justify-content: center; border-top: 1px solid rgba(255, 55, 55, 0.08); padding-top: 12px;">
                        <i class="nav-icon fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- TOP BAR -->
            <div class="topbar">
                <div class="topbar-left">
                    <h2>{{ isset($title) ? $title : 'Dashboard' }}</h2>
                    <p>{{ isset($subtitle) ? $subtitle : 'Kelola layanan Hunny Pet Care' }}</p>
                </div>
                <div class="topbar-right">
                    <div class="topbar-badge">
                        <span class="dot"></span> Sistem Aktif
                    </div>
                </div>
            </div>

            <!-- PAGE CONTENT -->
            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('app.js') }}"></script>
    @yield('scripts')
</body>
</html>
