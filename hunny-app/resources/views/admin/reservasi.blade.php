@extends('layouts.admin')

@section('title', 'Manajemen Reservasi')

@section('content')
<div class="topbar">
    <div class="topbar-left">
        <h1 class="page-title">Daftar Reservasi</h1>
        <p class="page-subtitle">Pantau dan kelola reservasi grooming yang masuk.</p>
    </div>
</div>

<div class="page-content">
    <div class="stats-grid" style="margin-bottom: 24px;">
        <div class="stat-card">
            <span class="stat-label">Total Reservasi</span>
            <span class="stat-value">{{ $bookings->total() }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Reservasi Mendatang</span>
            <span class="stat-value" style="color:var(--info)">{{ $bookings->where('tanggal_reservasi', '>=', now()->toDateString())->count() }}</span>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pemilik</th>
                        <th>Anabul</th>
                        <th>Layanan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->kode_booking }}</td>
                            <td>{{ $booking->nama_pemilik }}</td>
                            <td>{{ $booking->nama_hewan }}<br><span class="text-xs text-gray-500">{{ $booking->jenis_hewan }}</span></td>
                            <td>{{ $booking->jenis_layanan }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->tanggal_reservasi)->format('d M Y') }}</td>
                            <td>
                                <span class="status-tag status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('booking.edit', $booking) }}" class="btn btn-sm btn-outline">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-6 text-gray-500">Belum ada reservasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
</div>
@endsection