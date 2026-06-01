<x-guest-layout>
    <h1><i class="fas fa-sign-in-alt"></i> Masuk ke Akun</h1>
    <p class="text-center">Kelola layanan dan produk Hunny Pet Care</p>

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus autocomplete="email" placeholder="contoh@email.com">
            @error('email')
                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div style="position: relative;">
                <input id="password" type="password" name="password" class="form-control password-toggle-input" required autocomplete="current-password" placeholder="Masukkan password Anda" style="padding-right: 42px;">
                <button type="button" aria-label="Tampilkan password" onclick="togglePassword('password', 'passwordToggleIcon')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: transparent; color: #555; cursor: pointer; padding: 0; display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px;">
                    <i id="passwordToggleIcon" class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="checkbox-group">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Ingat saya</label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit"><i class="fas fa-lock"></i> Masuk</button>
        </div>

        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>

    </form>

    <script>
        function togglePassword(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            const hidden = field.type === 'password';
            field.type = hidden ? 'text' : 'password';
            icon.className = `fas ${hidden ? 'fa-eye-slash' : 'fa-eye'}`;
        }
    </script>
</x-guest-layout>
