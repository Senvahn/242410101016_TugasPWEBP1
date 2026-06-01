@extends('layouts.customer')

@section('title', 'Pembayaran Reservasi')

@section('content')
<div class="breadcrumb">
    <a href="{{ url('/') }}">Beranda</a>
    <i class="fas fa-chevron-right"></i>
    <a href="{{ route('booking.create') }}">Booking Grooming</a>
    <i class="fas fa-chevron-right"></i>
    <span>Pembayaran Reservasi</span>
</div>

<div class="cust-container">
    <div class="section-header">
        <h2>Checkout Reservasi</h2>
        <p>Lengkapi data pembayaran reservasi groom Anda dan konfirmasi pesanan.</p>
    </div>

    <div class="card shadow-sm checkout-card">
        <div class="card-header">
            <div>
                <p class="eyebrow">Checkout Reservasi</p>
                <h3>Lengkapi data dan konfirmasi reservasi</h3>
            </div>
            <span class="step-badge">Langkah 1 dari 1</span>
        </div>

        <div class="card-body">
            <div class="checkout-grid">
                <div class="checkout-form-panel">
                    <form id="bookingPaymentForm" class="form-grid" method="POST" action="{{ route('booking.pembayaran.process', $booking) }}">
                        @csrf

                        <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <select name="payment_method" class="form-control" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="Bayar di Toko">Bayar di Toko</option>
                                <option value="QRIS">QRIS</option>
                                <option value="E-Wallet">E-Wallet (OVO / GoPay)</option>
                            </select>
                            @error('payment_method')
                                <p class="text-danger text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group full-width">
                            <label>Catatan Reservasi</label>
                            <textarea class="form-control" rows="4" readonly>{{ $booking->catatan ?? 'Tidak ada catatan tambahan.' }}</textarea>
                        </div>

                        <div class="form-actions full-width">
                            <button type="submit" class="btn btn-accent btn-block">Konfirmasi Pembayaran</button>
                        </div>
                    </form>
                </div>

                <div class="card shadow-sm summary-card">
                    <div class="card-header">
                        <h3>Ringkasan Reservasi</h3>
                    </div>
                    <div class="card-body">
                        <div class="summary-row">
                            <span>Kode Reservasi</span>
                            <strong>{{ $booking->kode_booking }}</strong>
                        </div>
                        <div class="summary-row">
                            <span>Nama Pemilik</span>
                            <strong>{{ $booking->nama_pemilik }}</strong>
                        </div>
                        <div class="summary-row">
                            <span>Hewan</span>
                            <strong>{{ $booking->nama_hewan }} ({{ $booking->jenis_hewan }})</strong>
                        </div>
                        <div class="summary-row">
                            <span>Layanan</span>
                            <strong>{{ $booking->jenis_layanan }}</strong>
                        </div>
                        <div class="summary-row">
                            <span>Tanggal</span>
                            <strong>{{ \Carbon\Carbon::parse($booking->tanggal_reservasi)->format('d M Y') }}</strong>
                        </div>
                        <div class="summary-total">Status: {{ ucfirst($booking->status) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.checkout-card { max-width: 900px; margin: 0 auto; }
.checkout-grid { display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 24px; align-items: start; }
.checkout-form-panel { min-width: 0; }
.summary-card { background: rgba(255, 255, 255, 0.97); }
.summary-card .card-header { background: rgba(255, 255, 255, 0.98); }
.summary-row { display: flex; justify-content: space-between; align-items: center; gap: 14px; padding: 16px 0; border-bottom: 1px solid var(--border); }
.summary-row:last-child { border-bottom: none; }
.summary-row span { color: var(--text-muted); }
.summary-row strong { color: var(--text); }
.summary-total { margin-top: 16px; text-align: right; font-size: 1rem; font-weight: 700; color: var(--primary); }
.eyebrow { display: inline-block; margin-bottom: 8px; letter-spacing: 0.18em; text-transform: uppercase; color: var(--accent); font-size: 0.78rem; }
.step-badge { background: rgba(201, 137, 74, 0.14); color: var(--accent); padding: 8px 14px; border-radius: 999px; font-size: 0.8rem; font-weight: 700; }
.form-group label { font-weight: 600; font-size: 0.9rem; color: var(--primary); margin-bottom: 8px; display: block; }
.form-actions { display: flex; justify-content: flex-end; margin-top: 14px; }
.form-control { width: 100%; padding: 11px 14px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family: 'DM Sans', sans-serif; font-size: 0.95rem; color: var(--text); background: var(--cream); transition: var(--transition); outline: none; }
.form-control:focus { border-color: var(--accent); background: var(--white); box-shadow: 0 0 0 3px rgba(201,137,74,0.12); }
.btn-block { width: 100%; }
@media (max-width: 820px) {
    .checkout-grid { grid-template-columns: 1fr; }
    .form-actions { justify-content: center; }
}
</style>
@endsection