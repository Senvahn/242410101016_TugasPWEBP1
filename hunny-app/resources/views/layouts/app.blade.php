<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hunny Pet Care')</title>

    {{-- Global CSS --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    {{-- Style spesifik per halaman --}}
    @stack('styles')
</head>
<body>

    {{-- NAVBAR (di-include dari partial) --}}
    @include('partials.navbar')

    {{-- FLASH SESSION MESSAGE --}}
    @if(session('success'))
        <div class="flash-message flash-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="flash-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="flash-message flash-error">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="flash-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    {{-- MAIN CONTENT AREA --}}
    <main class="main-wrapper">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="page-footer-app">
        <div class="footer-inner">
            <div class="footer-brand-inline">
                <img src="{{ asset('logohunny.webp') }}" alt="Hunny Pet Care" onerror="this.style.display='none'">
                <strong>Hunny Pet Care</strong>
            </div>
            <p>&copy; {{ date('Y') }} Hunny Pet Care. Semua hak cipta dilindungi.</p>
            <p class="footer-tagline">
                Dibuat dengan <i class="fas fa-heart" style="color:#c9894a"></i> untuk para pecinta anabul.
            </p>
        </div>
    </footer>

    {{-- Inline style tambahan untuk layout master --}}
    <style>
        .main-wrapper { min-height: calc(100vh - 200px); }
        .flash-message {
            position: fixed; top: 84px; right: 20px; z-index: 500;
            background: #fff; border-left: 4px solid #38a169;
            padding: 14px 48px 14px 18px;
            border-radius: 8px;
            box-shadow: 0 12px 32px rgba(26,43,60,0.15);
            display: flex; align-items: center; gap: 10px;
            font-size: 0.875rem; color: #2d3748;
            animation: flashSlide 0.35s ease;
            max-width: 380px;
        }
        .flash-message.flash-error { border-left-color: #e53e3e; }
        .flash-message i { color: #38a169; font-size: 1.1rem; }
        .flash-message.flash-error i { color: #e53e3e; }
        .flash-close {
            position: absolute; top: 8px; right: 10px;
            background: none; border: none;
            font-size: 1.3rem; color: #718096;
            cursor: pointer; line-height: 1;
        }
        .flash-close:hover { color: #1a2b3c; }
        @keyframes flashSlide {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .page-footer-app {
            background: #1a2b3c; color: rgba(255,255,255,0.7);
            padding: 32px 40px; margin-top: 40px;
        }
        .footer-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
        }
        .footer-brand-inline {
            display: flex; align-items: center; gap: 10px;
            color: #fff;
        }
        .footer-brand-inline img { width: 36px; height: 36px; border-radius: 50%; }
        .footer-brand-inline strong {
            font-family: 'Playfair Display', serif;
            font-size: 1rem; color: #fff;
        }
        .footer-tagline { font-size: 0.82rem; opacity: 0.65; }
        @media (max-width: 640px) {
            .footer-inner { flex-direction: column; text-align: center; }
        }
    </style>

    {{-- Global JS --}}
    <script src="{{ asset('app.js') }}"></script>

    {{-- Stack script spesifik per halaman --}}
    @stack('scripts')
</body>
</html>