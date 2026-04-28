@extends('layouts.customer')

@section('title', 'Metode Pembayaran')

@section('content')
<div class="breadcrumb">
    <a href="{{ url('/') }}">Beranda</a>
    <i class="fas fa-chevron-right"></i>
    <a href="{{ url('/customer') }}">Belanja</a>
    <i class="fas fa-chevron-right"></i>
    <span>Metode Pembayaran</span>
</div>

<div class="pay-wrapper">
    <div class="pay-container">
        <h2 class="section-title">Detail Pembayaran</h2>
        
        <div class="card shadow-sm" style="margin-bottom: 20px;">
            <div id="orderSummary">
                </div>
        </div>

        <div class="payment-methods">
            <h3>Pilih Metode Pembayaran</h3>
            <div class="method-grid">
                <div class="method-card" onclick="selectMethod('Transfer Bank')">
                    <i class="fas fa-university"></i>
                    <span>Transfer Bank</span>
                </div>
                <div class="method-card" onclick="selectMethod('E-Wallet')">
                    <i class="fas fa-wallet"></i>
                    <span>E-Wallet (OVO/Gopay)</span>
                </div>
                <div class="method-card" onclick="selectMethod('Bayar di Toko')">
                    <i class="fas fa-store"></i>
                    <span>Bayar di Toko</span>
                </div>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 30px;">
            <button class="btn btn-accent btn-block" onclick="prosesBayar()">Konfirmasi Pembayaran</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let selectedMethod = '';

    function selectMethod(method) {
        selectedMethod = method;
        document.querySelectorAll('.method-card').forEach(c => c.classList.remove('active'));
        event.currentTarget.classList.add('active');
    }

    function prosesBayar() {
        if (!selectedMethod) {
            alert('Silakan pilih metode pembayaran dahulu.');
            return;
        }
        
        // Simpan ke localStorage konfirmasiPesanan untuk Admin
        const pendingOrder = JSON.parse(localStorage.getItem('pendingOrder'));
        if (pendingOrder) {
            let orders = JSON.parse(localStorage.getItem('konfirmasiPesanan')) || [];
            pendingOrder.metode = selectedMethod;
            pendingOrder.status = 'Menunggu Konfirmasi';
            orders.unshift(pendingOrder);
            localStorage.setItem('konfirmasiPesanan', JSON.stringify(orders));
            
            alert('Pesanan berhasil dibuat! Silakan cek menu Pesanan Saya.');
            window.location.href = "{{ url('/pesanan-saya') }}";
        }
    }

    // Load data pesanan saat halaman dibuka
    window.onload = function() {
        const order = JSON.parse(localStorage.getItem('pendingOrder'));
        if (!order) {
            window.location.href = "{{ url('/customer') }}";
            return;
        }
        document.getElementById('orderSummary').innerHTML = `
            <p><strong>Kode Pesanan:</strong> ${order.kode}</p>
            <p><strong>Total Bayar:</strong> Rp ${order.total.toLocaleString()}</p>
        `;
    };
</script>
@endsection