@extends('layouts.app')

@section('header')
    <h2><i class="fas fa-user-circle"></i> Profil Saya</h2>
    <p class="profile-subtitle">Kelola informasi akun dan pengaturan keamanan Anda</p>
@endsection

@section('content')
<div class="profile-page">
    <div class="card profile-summary">
        <div class="card-body">
            <div>
                <div class="profile-summary-title">Profil Akun</div>
                <div class="profile-summary-copy">Perbarui detail profil dan kata sandi Anda dengan mudah. Semua data disimpan aman, tampilan profesional, dan gaya tetap rapi untuk admin maupun pelanggan.</div>
            </div>
            <span class="profile-badge"><i class="fas fa-shield-alt"></i> Aman & Profesional</span>
        </div>
    </div>

    <div class="profile-grid">
        <div class="card profile-panel">
            <div class="card-header">
                <h3><i class="fas fa-info-circle"></i> Informasi Profil</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-accent">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    @if (session('status') === 'profile-updated')
                        <span class="success-text"><i class="fas fa-check-circle"></i> Profil berhasil diperbarui!</span>
                    @endif
                </div>
            </form>
        </div>
    </div>

        <div class="card profile-panel">
            <div class="card-header">
                <h3><i class="fas fa-lock"></i> Ubah Password</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="form-grid form-grid-full">
                        <div class="form-group">
                            <label for="update_password_current_password">Password Saat Ini</label>
                            <input id="update_password_current_password" name="current_password" type="password" class="form-control" required>
                            @error('current_password', 'updatePassword')
                                <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="update_password_password">Password Baru</label>
                            <input id="update_password_password" name="password" type="password" class="form-control" required>
                            @error('password', 'updatePassword')
                                <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="update_password_password_confirmation">Konfirmasi Password Baru</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" required>
                            @error('password_confirmation', 'updatePassword')
                                <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-accent">
                            <i class="fas fa-key"></i> Update Password
                        </button>
                        @if (session('status') === 'password-updated')
                            <span class="success-text"><i class="fas fa-check-circle"></i> Password berhasil diubah!</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="card profile-panel profile-delete">
            <div class="card-header">
                <h3><i class="fas fa-trash-alt"></i> Hapus Akun</h3>
            </div>
            <div class="card-body">
                <p class="profile-delete-copy">Menghapus akun akan menghapus semua data Anda secara permanen. Tindakan ini tidak dapat dikembalikan.</p>
                <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun Anda? Data tidak dapat dikembalikan.');">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-warning"></i> Hapus Akun Saya
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
