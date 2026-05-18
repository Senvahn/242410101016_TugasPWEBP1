@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Layanan Grooming & Perawatan</h1>
        <p class="text-sm text-gray-500 mt-1">Pilih layanan yang sesuai, lalu pesan langsung.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($services as $service)
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">{{ $service->name }}</h2>
                        <p class="text-sm text-gray-500 mt-2">{{ $service->description }}</p>
                        <div class="mt-4 flex items-center gap-3">
                            <div class="text-2xl font-bold text-pink-600">Rp {{ number_format($service->price,0,',','.') }}</div>
                            <div class="text-xs text-gray-400">Durasi: {{ $service->duration_minutes }} menit</div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-3">
                        <a href="{{ route('booking.create', ['service' => $service->name]) }}" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg text-sm font-medium">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
