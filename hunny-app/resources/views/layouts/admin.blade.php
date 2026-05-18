<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        function setCookie(name, value, days = 365) {
            const expires = new Date(Date.now() + days * 864e5).toUTCString();
            document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/; SameSite=Lax`;
        }

        function getCookie(name) {
            return document.cookie.split('; ').reduce((r, c) => {
                const [k, v] = c.split('=');
                return k === name ? decodeURIComponent(v) : r;
            }, '');
        }

        function deleteCookie(name) {
            document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; SameSite=Lax`;
        }

        function resolveTheme(theme) {
            if (theme === 'system') {
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            return theme;
        }

        function applyTheme(theme) {
            const resolved = resolveTheme(theme);
            document.documentElement.classList.toggle('dark', resolved === 'dark');
        }

        function applyFontSize(size) {
            document.documentElement.classList.remove('font-small', 'font-medium', 'font-large');
            document.documentElement.classList.add(`font-${size}`);
        }

        (function () {
            const theme = getCookie('hunny_theme') || 'system';
            const fontSize = getCookie('hunny_font_size') || 'medium';
            applyTheme(theme);
            applyFontSize(fontSize);
        })();
    </script>
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
                <a href="{{ route('preferensi.index') }}" class="nav-item {{ request()->is('preferensi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cog"></i> Preferensi
                </a>
                <button id="themeToggleBtn" class="nav-item" type="button">
                    <i class="nav-icon fas fa-moon"></i> Tema
                </button>
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