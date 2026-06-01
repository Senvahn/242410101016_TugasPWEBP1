@extends('layouts.app')

@section('header')
    <h2><i class="fas fa-credit-card"></i> Checkout Reservasi</h2>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Selesaikan pembayaran untuk konfirmasi reservasi grooming Anda</p>
@endsection

@section('content')
<div class="booking-checkout-page">
    <div class="checkout-container">
        <!-- LEFT SIDE: FORM -->
        <div class="checkout-left">
            <form action="{{ route('booking.checkout.process', $booking) }}" method="POST" enctype="multipart/form-data" id="checkoutForm">
                @csrf

                <!-- Data Pelanggan (Read-only) -->
                <div class="form-section">
                    <h3><i class="fas fa-user-circle"></i> Data Pelanggan</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Pemilik</label>
                            <input type="text" value="{{ $booking->nama_pemilik }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="{{ $booking->email }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <!-- Data Hewan -->
                <div class="form-section">
                    <h3><i class="fas fa-paw"></i> Data Hewan</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Hewan</label>
                            <input type="text" value="{{ $booking->nama_hewan }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jenis Hewan</label>
                            <input type="text" value="{{ $booking->jenis_hewan }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <!-- Detail Layanan & Jadwal -->
                <div class="form-section">
                    <h3><i class="fas fa-calendar-check"></i> Detail Reservasi</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Layanan</label>
                            <input type="text" value="{{ $booking->service?->name ?? $booking->jenis_layanan }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="text" value="{{ \Carbon\Carbon::parse($booking->tanggal_reservasi)->translatedFormat('d F Y') }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jam</label>
                            <input type="text" value="{{ $booking->pilihan_jam }}" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="form-section">
                    <h3><i class="fas fa-money-bill"></i> Metode Pembayaran</h3>
                    <div class="form-group full-width">
                        <label for="payment_method">Pilih Metode Pembayaran <span class="required">*</span></label>
                        <select id="payment_method" name="payment_method" class="form-control @error('payment_method') form-error-border @enderror" required onchange="togglePaymentProof()">
                            <option value="">-- Pilih Metode --</option>
                            <option value="QRIS" {{ old('payment_method', $booking->payment_method) == 'QRIS' ? 'selected' : '' }}>📱 QRIS</option>
                            <option value="E-Wallet" {{ old('payment_method', $booking->payment_method) == 'E-Wallet' ? 'selected' : '' }}>📲 E-Wallet</option>
                            <option value="Bayar di Toko" {{ old('payment_method', $booking->payment_method) == 'Bayar di Toko' ? 'selected' : '' }}>🏪 Bayar di Toko</option>
                        </select>
                        @error('payment_method')
                            <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instruksi QRIS -->
                    <div id="qrisInstruction" class="payment-instruction" style="display: none;">
                        <div class="instruction-box">
                            <h4><i class="fas fa-qrcode"></i> Instruksi Pembayaran QRIS</h4>
                            <p style="font-size: 0.9rem; color: #4a5568; margin: 0.5rem 0;">Pindai kode QR di bawah ini menggunakan aplikasi e-banking atau dompet digital Anda:</p>
                            <div class="qr-container">
                                <img src="{{ asset('images/payment/qris.jpg') }}" alt="QRIS" class="qr-image">
                            </div>
                            <p style="font-size: 0.85rem; color: #718096; margin: 0.5rem 0; text-align: center;">Setelah menyelesaikan pembayaran, unggah screenshot bukti transfer di bawah.</p>
                        </div>
                    </div>

                    <!-- Instruksi E-Wallet -->
                    <div id="ewalletInstruction" class="payment-instruction" style="display: none;">
                        <div class="instruction-box">
                            <h4><i class="fas fa-wallet"></i> Instruksi Pembayaran E-Wallet</h4>
                            <p style="font-size: 0.9rem; color: #4a5568; margin: 0.5rem 0;">Kirimkan dana ke salah satu nomor rekening berikut:</p>
                            <div class="account-list">
                                <div class="account-item">
                                    <span class="provider"><i class="fas fa-circle"></i> OVO</span>
                                    <span class="account-number">0821-XXXX-XXXX</span>
                                </div>
                                <div class="account-item">
                                    <span class="provider"><i class="fas fa-circle"></i> GoPay</span>
                                    <span class="account-number">0821-XXXX-XXXX</span>
                                </div>
                            </div>
                            <p style="font-size: 0.85rem; color: #718096; margin: 1rem 0 0.5rem 0;">Setelah transfer, unggah screenshot bukti pembayaran di bawah.</p>
                        </div>
                    </div>
                </div>

                <!-- Upload Bukti Pembayaran (Conditional) -->
                <div id="proofSection" class="form-section" style="display: none;">
                    <h3><i class="fas fa-receipt"></i> Bukti Pembayaran</h3>
                    <div class="form-group full-width">
                        <label for="payment_proof">Upload Bukti Pembayaran <span class="required">*</span></label>
                        <p class="form-help-text">Format: JPG, JPEG, PNG. Max 2MB. Lampirkan screenshot bukti transfer/pembayaran.</p>
                        <input type="file" id="payment_proof" name="payment_proof" accept="image/jpg,image/jpeg,image/png" class="form-control form-file @error('payment_proof') form-error-border @enderror">
                        @error('payment_proof')
                            <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions full-width">
                    <button type="submit" class="btn btn-accent btn-lg">Konfirmasi Pembayaran</button>
                    <a href="{{ route('booking.show', $booking) }}" class="btn btn-outline btn-lg">Kembali</a>
                </div>
            </form>
        </div>

        <!-- RIGHT SIDE: SUMMARY -->
        <div class="checkout-right">
            <div class="summary-card">
                <div class="summary-header">
                    <h3><i class="fas fa-receipt"></i> Ringkasan Reservasi</h3>
                </div>

                <div class="summary-content">
                    <!-- Kode Booking -->
                    <div class="summary-item">
                        <span class="label">Kode Booking</span>
                        <span class="value font-mono font-bold text-pink-600">{{ $booking->kode_booking }}</span>
                    </div>

                    <hr>

                    <!-- Detail Layanan -->
                    <div class="summary-section">
                        <h4>Layanan</h4>
                        <div class="summary-item">
                            <span class="label">Nama</span>
                            <span class="value">{{ $booking->service?->name ?? $booking->jenis_layanan }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="label">Hewan</span>
                            <span class="value">{{ $booking->nama_hewan }} ({{ $booking->jenis_hewan }})</span>
                        </div>
                        <div class="summary-item">
                            <span class="label">Tanggal</span>
                            <span class="value">{{ \Carbon\Carbon::parse($booking->tanggal_reservasi)->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="label">Jam</span>
                            <span class="value">{{ $booking->pilihan_jam }}</span>
                        </div>
                    </div>

                    <hr>

                    <!-- Harga -->
                    <div class="summary-section">
                        <h4>Rincian Harga</h4>
                        <div class="summary-item">
                            <span class="label">Harga Layanan</span>
                            <span class="value">Rp {{ number_format($booking->service?->price ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="label">Pajak (10%)</span>
                            <span class="value">Rp {{ number_format(($booking->service?->price ?? 0) * 0.1, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="summary-divider"></div>

                    <!-- Total -->
                    <div class="summary-item total">
                        <span class="label">Total Bayar</span>
                        <span class="value">Rp {{ number_format(($booking->service?->price ?? 0) * 1.1, 0, ',', '.') }}</span>
                    </div>

                    <!-- Status Badge -->
                    <div class="status-badge">
                        <i class="fas fa-hourglass-half"></i> Status: <strong>Pending</strong>
                    </div>

                    <!-- Info -->
                    <div class="summary-info">
                        <p><i class="fas fa-info-circle"></i> Simpan bukti pembayaran Anda untuk konfirmasi admin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.booking-checkout-page {
    padding: 2rem 0;
}

.checkout-container {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.checkout-left {
    padding: 0;
}

.checkout-right {
    position: sticky;
    top: 100px;
    height: fit-content;
}

.form-section {
    background: white;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.form-section h3 {
    margin: 0 0 1rem 0;
    font-size: 1.1rem;
    color: #2d3748;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-grid.full-width {
    grid-template-columns: 1fr;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.5rem;
}

.form-control {
    padding: 0.75rem;
    border: 1px solid #cbd5e0;
    border-radius: 8px;
    font-size: 0.95rem;
}

.form-control[readonly] {
    background-color: #f7fafc;
    cursor: not-allowed;
}

.form-help-text {
    font-size: 0.85rem;
    color: #718096;
    margin: 0.5rem 0;
}

.form-error {
    color: #e53e3e;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

.form-error-border {
    border-color: #e53e3e !important;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-accent {
    background-color: #ed64a6;
    color: white;
}

.btn-accent:hover {
    background-color: #ec407a;
}

.btn-outline {
    background-color: transparent;
    color: #ed64a6;
    border: 2px solid #ed64a6;
}

.btn-outline:hover {
    background-color: #fce7f3;
}

.btn-lg {
    padding: 1rem;
    font-size: 1rem;
    width: 100%;
}

.summary-card {
    background: #fefdfb;
    border: 1px solid #e8dcc8;
    border-radius: 12px;
    overflow: hidden;
    color: #3d2817;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.summary-header {
    background: #f9f7f4;
    padding: 1.5rem;
    border-bottom: 1px solid #e8dcc8;
}

.summary-header h3 {
    margin: 0;
    font-size: 1.2rem;
    color: #3d2817;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.summary-content {
    padding: 1.5rem;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.95rem;
    margin-bottom: 0.75rem;
    color: #3d2817;
}

.summary-item .label {
    opacity: 0.75;
}

.summary-item .value {
    font-weight: 600;
    text-align: right;
}

.summary-item.total {
    font-size: 1.2rem;
    margin-top: 1rem;
    color: #3d2817;
}

.summary-section {
    margin: 1rem 0;
}

.summary-section h4 {
    margin: 0 0 0.75rem 0;
    font-size: 0.9rem;
    color: #6b4423;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.summary-divider {
    height: 1px;
    background: #e8dcc8;
    margin: 1.5rem 0;
}

hr {
    border: none;
    height: 1px;
    background: #e8dcc8;
    margin: 1rem 0;
}

.status-badge {
    background: #f0ebe2;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    text-align: center;
    font-size: 0.9rem;
    margin: 1.5rem 0 1rem 0;
    border: 1px solid #e8dcc8;
    color: #3d2817;
}

.summary-info {
    background: #f9f7f4;
    padding: 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    margin-top: 1rem;
    line-height: 1.5;
    color: #4a5568;
}

.summary-info p {
    margin: 0;
}

.font-mono {
    font-family: 'Courier New', monospace;
}

.font-bold {
    font-weight: 700;
}

.text-pink-600 {
    color: #ec407a;
}

/* Payment Instruction Styles */
.payment-instruction {
    margin-top: 1rem;
}

.instruction-box {
    background: #fefdfb;
    border: 1px solid #e8dcc8;
    border-radius: 10px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.instruction-box h4 {
    margin: 0 0 1rem 0;
    font-size: 1rem;
    color: #3d2817;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.qr-container {
    text-align: center;
    margin: 1rem 0;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    border: 1px solid #e8dcc8;
}

.qr-image {
    max-width: 250px;
    height: auto;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.account-list {
    background: white;
    border-radius: 8px;
    border: 1px solid #e8dcc8;
    overflow: hidden;
    margin: 1rem 0;
}

.account-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #e8dcc8;
}

.account-item:last-child {
    border-bottom: none;
}

.account-item .provider {
    font-weight: 600;
    color: #3d2817;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.account-item .account-number {
    font-family: 'Courier New', monospace;
    color: #718096;
    font-weight: 500;
}

@media (max-width: 1024px) {
    .checkout-container {
        grid-template-columns: 1fr;
    }
    
    .checkout-right {
        position: static;
    }
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<script>
function togglePaymentProof() {
    const method = document.getElementById('payment_method').value;
    const proofSection = document.getElementById('proofSection');
    const proofInput = document.getElementById('payment_proof');
    const qrisInstruction = document.getElementById('qrisInstruction');
    const ewalletInstruction = document.getElementById('ewalletInstruction');
    
    // Reset all sections
    proofSection.style.display = 'none';
    qrisInstruction.style.display = 'none';
    ewalletInstruction.style.display = 'none';
    proofInput.required = false;
    proofInput.value = '';
    
    // Tampilkan sesuai metode yang dipilih
    if (method === 'QRIS') {
        qrisInstruction.style.display = 'block';
        proofSection.style.display = 'block';
        proofInput.required = true;
    } else if (method === 'E-Wallet') {
        ewalletInstruction.style.display = 'block';
        proofSection.style.display = 'block';
        proofInput.required = true;
    }
}

// Panggil saat halaman dimuat untuk memastikan state awal benar
document.addEventListener('DOMContentLoaded', function() {
    togglePaymentProof();
});
</script>
@endsection
