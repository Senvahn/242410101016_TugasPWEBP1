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
    <div class="stats-grid">
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
                        <th>Harga</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Bukti</th>
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
                            <td>Rp {{ number_format($booking->service->price ?? 0, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->tanggal_reservasi)->format('d M Y') }}</td>
                            <td>
                                <span class="status-tag status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    @if($booking->payment_proof)
                                        <button class="btn btn-sm btn-outline" onclick="openProofModal('payment', '{{ asset('storage/' . $booking->payment_proof) }}', 'Bukti Pembayaran')">📷 Bayar</button>
                                    @endif
                                    @if($booking->pet_photo)
                                        <button class="btn btn-sm btn-outline" onclick="openProofModal('photo', '{{ asset('storage/' . $booking->pet_photo) }}', 'Foto Hewan')">🐾 Hewan</button>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="flex gap-1">
                                    @if($booking->status === 'pending')
                                        <form action="{{ route('admin.booking.status', $booking) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-sm btn-success">✓ Konfirmasi</button>
                                        </form>
                                        <form action="{{ route('admin.booking.status', $booking) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin membatalkan reservasi?')">✕ Tolak</button>
                                        </form>
                                    @endif
                                    @if($booking->status === 'confirmed')
                                        <form action="{{ route('admin.booking.status', $booking) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="status" value="done">
                                            <button type="submit" class="btn btn-sm btn-info">✓ Selesai</button>
                                        </form>
                                    @endif
                                    @if($booking->status !== 'cancelled' && $booking->status !== 'done')
                                        <form action="{{ route('booking.destroy', $booking) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">🗑️ Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center p-6 text-gray-500">Belum ada reservasi.</td>
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

<!-- Proof Viewer Modal -->
<div id="proofModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:8px; padding:20px; max-width:500px; max-height:80vh; overflow:auto; position:relative;">
        <button onclick="closeProofModal()" style="position:absolute; top:10px; right:10px; background:none; border:none; font-size:24px; cursor:pointer;">&times;</button>
        <h2 id="proofTitle" style="margin-top:0; color:#333;"></h2>
        <img id="proofImage" src="" alt="Bukti" style="width:100%; height:auto; border-radius:8px; margin-top:10px;">
    </div>
</div>

<script>
function openProofModal(type, imageUrl, title) {
    document.getElementById('proofTitle').textContent = title;
    document.getElementById('proofImage').src = imageUrl;
    document.getElementById('proofModal').style.display = 'flex';
}

function closeProofModal() {
    document.getElementById('proofModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('proofModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeProofModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeProofModal();
    }
});
</script>

@endsection