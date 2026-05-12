@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('booking.index') }}" class="text-pink-500 hover:underline text-sm">← Kembali</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-1">🐾 Buat Reservasi Baru</h1>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Nama Pemilik --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik <span class="text-red-500">*</span></label>
                <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 @error('nama_pemilik') border-red-400 @enderror"
                       placeholder="Masukkan nama pemilik hewan">
                @error('nama_pemilik')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 @error('email') border-red-400 @enderror"
                       placeholder="contoh@email.com">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama & Jenis Hewan --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Hewan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_hewan" value="{{ old('nama_hewan') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 @error('nama_hewan') border-red-400 @enderror"
                           placeholder="cth: Mochi">
                    @error('nama_hewan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Hewan <span class="text-red-500">*</span></label>
                    <select name="jenis_hewan"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 @error('jenis_hewan') border-red-400 @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach(['Anjing','Kucing','Kelinci','Lainnya'] as $jenis)
                            <option value="{{ $jenis }}" {{ old('jenis_hewan') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                    @error('jenis_hewan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Jenis Layanan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan <span class="text-red-500">*</span></label>
                <select name="jenis_layanan"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 @error('jenis_layanan') border-red-400 @enderror">
                    <option value="">-- Pilih Layanan --</option>
                    @foreach(['Basic Grooming','Full Grooming','Spa & Treatment','Nail Trimming'] as $layanan)
                        <option value="{{ $layanan }}" {{ old('jenis_layanan') == $layanan ? 'selected' : '' }}>{{ $layanan }}</option>
                    @endforeach
                </select>
                @error('jenis_layanan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Reservasi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Reservasi <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_reservasi" value="{{ old('tanggal_reservasi') }}"
                       min="{{ date('Y-m-d') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 @error('tanggal_reservasi') border-red-400 @enderror">
                @error('tanggal_reservasi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Foto Hewan (BONUS) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Hewan <span class="text-gray-400 text-xs">(opsional, max 2MB)</span></label>
                <input type="file" name="foto_hewan" accept="image/jpg,image/jpeg,image/png"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-pink-50 file:text-pink-600 hover:file:bg-pink-100 @error('foto_hewan') border border-red-400 rounded-lg @enderror">
                @error('foto_hewan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Catatan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan <span class="text-gray-400 text-xs">(opsional)</span></label>
                <textarea name="catatan" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                          placeholder="Alergi, kondisi khusus hewan, dll...">{{ old('catatan') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                    Simpan Reservasi
                </button>
                <a href="{{ route('booking.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg text-sm font-medium transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection