<x-guest-layout>
    <h1><i class="fas fa-user-plus"></i> Buat Akun Baru</h1>
    <p class="text-center">Bergabunglah dengan Hunny Pet Care</p>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus autocomplete="name" placeholder="Masukkan nama Anda">
            @error('name')
                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autocomplete="email" placeholder="contoh@email.com">
            @error('email')
                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div style="position: relative;">
                <input id="password" type="password" name="password" class="form-control password-toggle-input" required autocomplete="new-password" placeholder="Minimal 8 karakter" style="padding-right: 42px;">
                <button type="button" onclick="togglePassword('password', 'passwordToggleIcon')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: transparent; color: #555; cursor: pointer; padding: 0; display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px;">
                    <i id="passwordToggleIcon" class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <div style="position: relative;">
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control password-toggle-input" required autocomplete="new-password" placeholder="Ulangi password" style="padding-right: 42px;">
                <button type="button" aria-label="Tampilkan password konfirmasi" onclick="togglePassword('password_confirmation', 'passwordConfirmationToggleIcon')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: transparent; color: #555; cursor: pointer; padding: 0; display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px;">
                    <i id="passwordConfirmationToggleIcon" class="fas fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation')
                <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit"><i class="fas fa-user-check"></i> Daftar</button>
        </div>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
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
