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
            const theme = getCookie('hunny_theme') || 'light';
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

<nav class="cust-nav">
    <div class="cust-nav-inner">
        <a href="{{ url('/') }}" class="cust-nav-brand">
            <img src="{{ asset('logohunny.webp') }}" alt="Hunny Logo">
            <span>Hunny Pet Care</span>
        </a>
        <div class="cust-nav-right">
            <a href="{{ url('/') }}" class="cust-nav-tab {{ request()->routeIs('beranda') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Beranda
            </a>
            <a href="{{ route('shop.index') }}" class="cust-nav-tab {{ request()->routeIs('shop.index') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i> Belanja Produk
            </a>
            <a href="{{ route('booking.create') }}" class="cust-nav-tab {{ request()->routeIs('booking.create') ? 'active' : '' }}">
                <i class="fas fa-calendar-plus"></i> Booking Jasa Grooming
            </a>
            <a href="{{ route('pesanan.saya') }}" class="cust-nav-tab {{ request()->routeIs('pesanan.saya') ? 'active' : '' }}">
                <i class="fas fa-box"></i> Pesanan Saya
            </a>
            <a href="{{ route('booking.index') }}" class="cust-nav-tab {{ request()->routeIs('booking.index') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> Reservasi Saya
            </a>
        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<script src="{{ asset('app.js') }}"></script>
@yield('scripts')
</body>
</html>