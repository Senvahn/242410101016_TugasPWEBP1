@extends('layouts.app')

@section('header')
    <h2><i class="fas fa-plus-circle"></i> Buat Reservasi Baru</h2>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Pesan layanan grooming untuk hewan peliharaan Anda</p>
@endsection

@section('content')
<div class="booking-page">
    <div class="card booking-card">
        <div class="card-header booking-card-header">
            <div>
                <h3><i class="fas fa-calendar-plus"></i> Formulir Reservasi</h3>
                <p class="booking-subtitle">Isi semua data di bawah agar layanan grooming hewan peliharaan Anda dapat kami proses dengan cepat dan rapi.</p>
            </div>
            <span class="status-tag status-pending">Formulir baru</span>
        </div>

        <div class="card-body">
            <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label for="nama_pemilik">Nama Pemilik <span class="required">*</span></label>
                        <input type="text" id="nama_pemilik" name="nama_pemilik" value="{{ old('nama_pemilik', optional(Auth::user())->name) }}" class="form-control" placeholder="Masukkan nama pemilik hewan" required>
                        @error('nama_pemilik')
                            <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', optional(Auth::user())->email) }}" class="form-control @error('email') form-error-border @enderror" placeholder="contoh@email.com">
                        @error('email')
                            <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_hewan">Nama Hewan <span class="required">*</span></label>
                        <input type="text" id="nama_hewan" name="nama_hewan" value="{{ old('nama_hewan') }}" class="form-control @error('nama_hewan') form-error-border @enderror" placeholder="cth: Mochi">
                        @error('nama_hewan')
                            <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jenis_hewan">Jenis Hewan <span class="required">*</span></label>
                        <select id="jenis_hewan" name="jenis_hewan" class="form-control @error('jenis_hewan') form-error-border @enderror">
                            <option value="">-- Pilih --</option>
                            @foreach(['Anjing','Kucing','Kelinci','Lainnya'] as $jenis)
                                <option value="{{ $jenis }}" {{ old('jenis_hewan') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                            @endforeach
                        </select>
                        @error('jenis_hewan')
                            <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="service_id">Jenis Layanan <span class="required">*</span></label>
                    <select id="service_id" name="service_id" class="form-control @error('service_id') form-error-border @enderror" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pilihan_jam">Pilihan Jam <span class="required">*</span></label>
                    <select id="pilihan_jam" name="pilihan_jam" class="form-control @error('pilihan_jam') form-error-border @enderror" required>
                        <option value="">-- Pilih Jam --</option>
                        @foreach(range(8, 17) as $jam)
                            @php($hour = sprintf('%02d:00', $jam))
                            <option value="{{ $hour }}" {{ old('pilihan_jam') == $hour ? 'selected' : '' }}>{{ $hour }}</option>
                        @endforeach
                    </select>
                    @error('pilihan_jam')
                        <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_reservasi">Tanggal Reservasi <span class="required">*</span></label>
                    <input type="date" id="tanggal_reservasi" name="tanggal_reservasi" value="{{ old('tanggal_reservasi') }}" min="{{ date('Y-m-d') }}" class="form-control @error('tanggal_reservasi') form-error-border @enderror">
                    @error('tanggal_reservasi')
                        <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="pet_photo">Foto Hewan <span class="optional">(opsional, max 2MB)</span></label>
                    <input type="file" id="pet_photo" name="pet_photo" accept="image/jpg,image/jpeg,image/png" class="form-control form-file @error('pet_photo') form-error-border @enderror">
                    @error('pet_photo')
                        <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="catatan">Catatan <span class="optional">(opsional)</span></label>
                    <textarea id="catatan" name="catatan" rows="4" class="form-control" placeholder="Alergi, kondisi khusus hewan, dll...">{{ old('catatan') }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-accent btn-sm">Simpan Reservasi</button>
                    <a href="{{ route('booking.index') }}" class="btn-outline btn-sm">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection