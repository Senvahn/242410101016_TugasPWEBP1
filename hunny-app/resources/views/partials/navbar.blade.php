{{-- ===== NAVBAR PARTIAL ===== --}}
<nav class="app-navbar" id="appNavbar">
    <div class="nav-container">
        <a href="{{ url('/') }}" class="nav-brand-app">
            <img src="{{ asset('logohunny.webp') }}" alt="Hunny Logo" onerror="this.style.display='none'">
            <span class="nav-brand-name-app">Hunny Pet Care</span>
        </a>

        <button class="nav-toggle" type="button" onclick="document.getElementById('appNavMenu').classList.toggle('open')">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="nav-menu" id="appNavMenu">
            <li>
                <a href="{{ url('/dashboard') }}" class="nav-link-app {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ url('/tentang') }}" class="nav-link-app {{ request()->is('tentang') ? 'active' : '' }}">
                    <i class="fas fa-info-circle"></i> Tentang
                </a>
            </li>
            <li>
                <a href="{{ url('/kontak') }}" class="nav-link-app {{ request()->is('kontak') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> Kontak
                </a>
            </li>
            <li>
                <a href="{{ url('/customer') }}" class="nav-link-app {{ request()->is('customer') ? 'active' : '' }}">
                    <i class="fas fa-store"></i> Customer
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/input') }}" class="nav-link-app-cta">
                    <i class="fas fa-user-shield"></i> Admin Panel
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
    .app-navbar {
        position: sticky; top: 0; z-index: 100;
        background: #fff;
        border-bottom: 1px solid #e2d9cc;
        box-shadow: 0 2px 12px rgba(26,43,60,0.06);
    }
    .nav-container {
        max-width: 1280px; margin: 0 auto;
        padding: 0 32px; height: 68px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .nav-brand-app {
        display: flex; align-items: center; gap: 12px;
        text-decoration: none;
    }
    .nav-brand-app img {
        width: 40px; height: 40px;
        border-radius: 50%;
        border: 2px solid #c9894a;
        object-fit: cover;
    }
    .nav-brand-name-app {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem; font-weight: 700;
        color: #1a2b3c;
    }
    .nav-menu {
        display: flex; align-items: center; gap: 8px;
        list-style: none; margin: 0; padding: 0;
    }
    .nav-link-app {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 8px 16px;
        border-radius: 99px;
        font-size: 0.875rem; font-weight: 600;
        color: #718096;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .nav-link-app:hover {
        background: #faf7f2;
        color: #c9894a;
    }
    .nav-link-app.active {
        background: rgba(201,137,74,0.1);
        color: #c9894a;
    }
    .nav-link-app-cta {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 9px 20px;
        border-radius: 99px;
        font-size: 0.875rem; font-weight: 600;
        background: linear-gradient(135deg, #c9894a, #e8b07a);
        color: #fff !important;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(201,137,74,0.3);
        transition: all 0.25s ease;
    }
    .nav-link-app-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(201,137,74,0.4);
    }
    .nav-toggle {
        display: none;
        background: none; border: none;
        font-size: 1.2rem; color: #1a2b3c;
        cursor: pointer;
    }
    @media (max-width: 860px) {
        .nav-container { padding: 0 20px; }
        .nav-toggle { display: block; }
        .nav-menu {
            position: absolute; top: 68px; right: 0;
            flex-direction: column; align-items: stretch;
            background: #fff;
            width: 240px;
            padding: 12px;
            border: 1px solid #e2d9cc;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 12px 32px rgba(26,43,60,0.12);
            display: none; gap: 4px;
        }
        .nav-menu.open { display: flex; }
        .nav-link-app, .nav-link-app-cta { justify-content: flex-start; }
    }
</style>