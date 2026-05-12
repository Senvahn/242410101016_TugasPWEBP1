@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('booking.index') }}" class="text-pink-500 hover:underline text-sm">← Kembali ke Daftar</a>
        <h1 class="text-2xl font-bold text-gray-800 mt-1">🐾 Detail Reservasi</h1>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        {{-- Header Card --}}
        <div class="bg-gradient-to-r from-pink-400 to-rose-400 px-6 py-5 flex items-center gap-4">
            @if($booking->foto_hewan)
                <img src="{{ asset('storage/' . $booking->foto_hewan) }}"
                     class="w-16 h-16 rounded-full object-cover border-2 border-white shadow">
            @else
                <div class="w-16 h-16 rounded-full bg-white/30 flex items-center justify-center text-3xl">🐶</div>
            @endif
            <div>
                <p class="font-mono text-white/80 text-sm">{{ $booking->kode_booking }}</p>
                <h2 class="text-xl font-bold text-white">{{ $booking->nama_hewan }}</h2>
                <p class="text-white/80 text-sm">{{ $booking->jenis_hewan }}</p>
            </div>
        </div>

        {{-- Detail Info --}}
        <div class="p-6 space-y-4">
            @php
                $fields = [
                    '👤 Nama Pemilik' => $booking->nama_pemilik,
                    '📧 Email'        => $booking->email,
                    '✂️ Layanan'      => $booking->jenis_layanan,
                    '📅 Tanggal'      => \Carbon\Carbon::parse($booking->tanggal_reservasi)->translatedFormat('d F Y'),
                ];
                $statusColor = [
                    'pending'   => 'bg-yellow-100 text-yellow-700',
                    'confirmed' => 'bg-blue-100 text-blue-700',
                    'done'      => 'bg-green-100 text-green-700',
                    'cancelled' => 'bg-red-100 text-red-700',
                ][$booking->status] ?? '';
            @endphp

            @foreach($fields as $label => $value)
            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-sm text-gray-500">{{ $label }}</span>
                <span class="text-sm font-medium text-gray-800">{{ $value }}</span>
            </div>
            @endforeach

            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                <span class="text-sm text-gray-500">🏷️ Status</span>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">{{ ucfirst($booking->status) }}</span>
            </div>

            @if($booking->catatan)
            <div class="py-2">
                <p class="text-sm text-gray-500 mb-1">📝 Catatan</p>
                <p class="text-sm text-gray-700 bg-gray-50 rounded-lg px-3 py-2">{{ $booking->catatan }}</p>
            </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="px-6 pb-6 flex gap-3">
            <a href="{{ route('booking.edit', $booking) }}"
               class="bg-yellow-400 hover:bg-yellow-500 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                ✏️ Edit
            </a>
            <form action="{{ route('booking.destroy', $booking) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus reservasi {{ $booking->kode_booking }}?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                    🗑️ Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection