@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('booking.index') }}" class="text-pink-500 hover:underline text-sm">← Kembali</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-1">✏️ Edit Reservasi</h1>
        <p class="text-sm text-gray-500">Kode: <span class="font-mono font-semibold text-pink-600">{{ $booking->kode_booking }}</span></p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('booking.update', $booking) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama Pemilik --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik <span class="text-red-500">*</span></label>
                <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik', $booking->nama_pemilik) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 @error('nama_pemilik') border-red-400 @enderror">
                @error('nama_pemilik')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $booking->email) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama & Jenis Hewan --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Hewan <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_hewan" value="{{ old('nama_hewan', $booking->nama_hewan) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 @error('nama_hewan') border-red-400 @enderror">
                    @error('nama_hewan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Hewan <span class="text-red-500">*</span></label>
                    <select name="jenis_hewan"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                        @foreach(['Anjing','Kucing','Kelinci','Lainnya'] as $jenis)
                            <option value="{{ $jenis }}" {{ old('jenis_hewan', $booking->jenis_hewan) == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Jenis Layanan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan <span class="text-red-500">*</span></label>
                <select name="service_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 @error('service_id') border-red-400 @enderror">
                    <option value="">-- Pilih Layanan --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id', $booking->service_id) == $service->id ? 'selected' : '' }}>
                            {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('service_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Pilihan Jam --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilihan Jam <span class="text-red-500">*</span></label>
                <select name="pilihan_jam"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 @error('pilihan_jam') border-red-400 @enderror">
                    @foreach(range(8, 17) as $jam)
                        @php($hour = sprintf('%02d:00', $jam))
                        <option value="{{ $hour }}" {{ old('pilihan_jam', $booking->pilihan_jam) == $hour ? 'selected' : '' }}>{{ $hour }}</option>
                    @endforeach
                </select>
                @error('pilihan_jam')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Reservasi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Reservasi <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_reservasi"
                       value="{{ old('tanggal_reservasi', \Carbon\Carbon::parse($booking->tanggal_reservasi)->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400 @error('tanggal_reservasi') border-red-400 @enderror">
                @error('tanggal_reservasi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">
                    @foreach(['pending','confirmed','done','cancelled'] as $s)
                        <option value="{{ $s }}" {{ old('status', $booking->status) == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Foto Hewan (BONUS) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Hewan <span class="text-gray-400 text-xs">(biarkan kosong jika tidak diganti)</span></label>
                @if($booking->foto_hewan)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $booking->foto_hewan) }}"
                             class="w-20 h-20 rounded-lg object-cover border border-pink-200">
                        <p class="text-xs text-gray-400 mt-1">Foto saat ini</p>
                    </div>
                @endif
                <input type="file" name="foto_hewan" accept="image/jpg,image/jpeg,image/png"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-pink-50 file:text-pink-600 hover:file:bg-pink-100">
                @error('foto_hewan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Catatan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <textarea name="catatan" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400">{{ old('catatan', $booking->catatan) }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
                    Update Reservasi
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