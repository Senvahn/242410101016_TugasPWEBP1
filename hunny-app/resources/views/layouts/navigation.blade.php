<nav x-data="{ open: false }" class="header-nav">
    <div class="header-nav-inner">
        <div class="header-nav-left">
            <a href="{{ route('beranda') }}" class="header-nav-logo">
                <img src="{{ asset('logohunny.webp') }}" alt="Logo" class="header-nav-logo-img">
                <span class="header-nav-logo-text">Hunny Pet Care</span>
            </a>
        </div>

        <div class="header-nav-right">
            <div class="header-nav-user-card">
                <i class="fas fa-user-circle header-nav-user-icon"></i>
                <div class="header-nav-user-info">
                    <div class="header-nav-user-name">{{ Auth::user()->name }}</div>
                    <div class="header-nav-user-role">{{ auth()->user()->isAdmin() ? 'Admin' : 'Customer' }}</div>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="header-nav-button">
                <i class="fas fa-user-circle"></i> Profil Saya
            </a>
            <form method="POST" action="{{ route('logout') }}" class="header-nav-form">
                @csrf
                <button type="submit" class="header-nav-button">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</nav>
