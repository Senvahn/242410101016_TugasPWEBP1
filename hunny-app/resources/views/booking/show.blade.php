@extends('layouts.app')

@section('title', 'Detail Reservasi - Hunny Pet Care')

@section('content')
<div class="w-full min-h-screen bg-[#f9f7f4] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-[#e8dcc8] overflow-hidden">
            
            <!-- Header -->
            <div class="p-6 bg-[#f9f7f4] border-b border-[#e8dcc8] flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-[#3d2817] flex items-center gap-2">
                        🐾 Detail Reservasi
                    </h1>
                    <p class="text-xs text-gray-500 mt-2">Kode: <span class="font-mono font-bold text-[#8b6f47]">{{ $booking->kode_booking ?? $booking->id }}</span></p>
                </div>
                <a href="{{ route('booking.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium transition-colors hover:opacity-80" style="background:#e8dcc8;color:#3d2817">
                    ← Kembali ke Daftar Reservasi Grooming
                </a>
            </div>

            <!-- Konten -->
            <div class="p-8 space-y-4">
                
                <!-- Nama & Jenis Hewan -->
                <div class="flex justify-between items-center py-3 px-4 bg-[#fefdfb] rounded-lg border border-[#e8dcc8]/50">
                    <span class="text-sm font-medium text-[#6b5637]">Nama Hewan</span>
                    <span class="text-sm font-semibold text-[#3d2817]">{{ $booking->nama_hewan }} - {{ $booking->jenis_hewan }}</span>
                </div>

                <!-- Jasa Layanan -->
                <div class="flex justify-between items-center py-3 px-4 bg-[#fefdfb] rounded-lg border border-[#e8dcc8]/50">
                    <span class="text-sm font-medium text-[#6b5637]">Jasa Layanan</span>
                    <span class="text-sm font-semibold text-[#3d2817]">{{ $booking->service->name ?? 'Layanan' }}</span>
                </div>

                <!-- Waktu Reservasi -->
                <div class="flex justify-between items-center py-3 px-4 bg-[#fefdfb] rounded-lg border border-[#e8dcc8]/50">
                    <span class="text-sm font-medium text-[#6b5637]">Tanggal & Jam</span>
                    <span class="text-sm font-semibold text-[#3d2817]">{{ \Carbon\Carbon::parse($booking->tanggal_reservasi)->translatedFormat('d M Y') }} • {{ $booking->pilihan_jam }}</span>
                </div>

                <!-- Harga Layanan -->
                <div class="flex justify-between items-center py-3 px-4 bg-[#fefdfb] rounded-lg border border-[#e8dcc8]/50">
                    <span class="text-sm font-medium text-[#6b5637]">Harga Layanan</span>
                    <span class="text-sm font-semibold text-[#3d2817]">Rp {{ number_format($booking->service->price ?? 0, 0, ',', '.') }}</span>
                </div>

                <!-- Status -->
                <div class="flex justify-between items-center py-3 px-4 bg-[#fefdfb] rounded-lg border border-[#e8dcc8]/50">
                    <span class="text-sm font-medium text-[#6b5637]">Status</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
