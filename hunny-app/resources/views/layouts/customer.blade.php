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

<nav class="cust-nav">
    <a href="{{ url('/') }}" class="cust-nav-brand">
        <img src="{{ asset('logohunny.webp') }}" alt="Hunny Logo">
        <span>Hunny Pet Care</span>
    </a>
    <div class="cust-nav-right">
        <a href="{{ url('/') }}" class="cust-nav-tab {{ request()->is('/') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Beranda
        </a>
        <a href="{{ url('/pesanan-saya') }}" class="cust-nav-tab {{ request()->is('pesanan-saya') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Pesanan Saya
        </a>
        <button class="cart-btn" onclick="openCart()">
            <i class="fas fa-shopping-bag"></i> Keranjang
            <span class="cart-badge" id="cartBadge" style="display:none;">0</span>
        </button>
    </div>
</nav>

<main>
    @yield('content')
</main>

<script src="{{ asset('app.js') }}"></script>
@yield('scripts')
</body>
</html>