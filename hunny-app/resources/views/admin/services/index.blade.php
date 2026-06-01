@extends('layouts.admin')

@section('title', 'Kelola Jasa Grooming')

@section('content')
<div class="topbar">
    <div class="topbar-left">
        <h1 class="page-title">Kelola Jasa Grooming</h1>
        <p class="page-subtitle">Tambah, edit, atau hapus layanan grooming yang tersedia untuk booking customer.</p>
    </div>
    <div class="topbar-right">
        <a href="{{ route('admin.services.create') }}" class="btn btn-accent">Tambah Jasa Baru</a>
    </div>
</div>

<div class="page-content">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Nama Jasa</th>
                        <th class="px-4 py-2 text-right">Harga</th>
                        <th class="px-4 py-2 text-center">Durasi</th>
                        <th class="px-4 py-2 text-center">Status</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td class="px-4 py-3">{{ $service->name }}</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-center">{{ $service->duration_minutes }} menit</td>
                            <td class="px-4 py-3 text-center">{{ $service->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline">Edit</a>
                                @if($service->is_active)
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" style="display:inline-block; margin-left:6px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-warning">Nonaktifkan</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.services.restore', $service) }}" method="POST" style="display:inline-block; margin-left:6px;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success">Pulihkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-6 text-gray-500">Belum ada jasa grooming. Tambahkan layanan baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $services->links() }}
    </div>
</div>
@endsection
