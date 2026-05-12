@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="text-center">
        <div class="text-8xl mb-4">🐾</div>
        <h1 class="text-4xl font-bold text-gray-800 mb-2">403</h1>
        <p class="text-gray-500 mb-6">Akses ditolak. Halaman ini hanya untuk Admin.</p>
        <a href="{{ route('booking.index') }}"
           class="bg-pink-500 hover:bg-pink-600 text-white px-6 py-2 rounded-lg text-sm font-medium transition">
            ← Kembali ke Beranda
        </a>
    </div>
</div>
@endsection