@extends('layouts.admin')

@section('title', 'Konfirmasi Pesanan')

@section('content')
<div class="topbar">
    <div class="topbar-left">
        <h1 class="page-title">Konfirmasi Pesanan</h1>
        <p class="page-subtitle">Kelola pesanan pelanggan dan setujui atau tolak pesanan yang masuk.</p>
    </div>
    <div class="topbar-right">
        <button class="btn btn-outline" onclick="window.location.reload()">
            <i class="fas fa-sync-alt"></i> Refresh Data
        </button>
    </div>
</div>

<div class="page-content">
    <div class="stats-grid" style="margin-bottom: 24px;">
        <div class="stat-card">
            <span class="stat-label">Total Pesanan</span>
            <span class="stat-value">{{ $totalOrders }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Perlu Konfirmasi</span>
            <span class="stat-value" style="color:var(--warning)">{{ $pendingOrders }}</span>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td><strong>{{ $order->order_code }}</strong></td>
                            <td>{{ $order->nama_pemesan }}</td>
                            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="status-tag status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>
                                @if($order->status === 'pending')
                                    <button class="btn btn-sm btn-outline" onclick="updateStatus({{ $order->id }}, 'confirmed')">Konfirmasi</button>
                                    <button class="btn btn-sm btn-danger" onclick="updateStatus({{ $order->id }}, 'cancelled')">Tolak</button>
                                @else
                                    <span class="text-sm text-gray-600">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-6 text-gray-500">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    async function updateStatus(orderId, status) {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        const response = await fetch(`/admin/orders/${orderId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status }),
        });

        if (!response.ok) {
            alert('Gagal memperbarui status pesanan.');
            return;
        }

        const json = await response.json();
        if (!json.success) {
            alert('Gagal memperbarui status pesanan.');
            return;
        }

        window.location.reload();
    }
</script>
@endsection