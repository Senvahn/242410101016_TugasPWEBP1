@extends('layouts.customer')

@section('title', 'Checkout')

@section('content')
<div class="breadcrumb">
    <a href="{{ url('/') }}">Beranda</a>
    <i class="fas fa-chevron-right"></i>
    <a href="{{ url('/shop') }}">Toko</a>
    <i class="fas fa-chevron-right"></i>
    <span>Checkout</span>
</div>

<div class="cust-container">
    <div class="section-header">
        <h2>Checkout Pesanan</h2>
        <p>Lengkapi data pelanggan dan pilih metode pembayaran.</p>
    </div>

    <div class="card shadow-sm" style="max-width: 760px; margin: 0 auto;">
        <div class="p-6">
            <div id="checkoutPreview" class="mb-6"></div>

            <form id="checkoutForm" class="space-y-5">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_pemesan" id="nama_pemesan" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="text" name="telepon" id="telepon" class="form-control" placeholder="0812xxxx" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="contoh@email.com">
                </div>
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="">Pilih Metode Pembayaran</option>
                        <option value="Cash">Bayar di Toko</option>
                        <option value="QRIS">QRIS</option>
                        <option value="E-Wallet">E-Wallet (OVO / GoPay)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Catatan Tambahan</label>
                    <textarea name="note" id="note" class="form-control" rows="4" placeholder="Permintaan khusus atau informasi tambahan..."></textarea>
                </div>
                <div class="form-actions" style="justify-content:flex-end; margin-top: 16px;">
                    <button type="submit" class="btn btn-accent btn-block">Kirim Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const CART_KEY = 'hunny_cart';
    const checkoutPreview = document.getElementById('checkoutPreview');
    const checkoutForm = document.getElementById('checkoutForm');
    const checkoutUrl = '{{ route('checkout.process') }}';
    const shopUrl = '{{ route('shop.index') }}';
    const orderHistoryUrl = '{{ route('pesanan.saya') }}';

    function formatRupiah(number) {
        return Number(number).toLocaleString('id-ID');
    }

    function loadCart() {
        return JSON.parse(localStorage.getItem(CART_KEY)) || [];
    }

    function renderPreview() {
        const cart = loadCart();
        if (!cart.length) {
            window.location.href = shopUrl;
            return;
        }

        const rows = cart.map(item => `
            <div class="flex items-center justify-between gap-4 p-3 border-b border-gray-200">
                <div>
                    <div class="font-semibold">${item.name}</div>
                    <div class="text-xs text-gray-500">${item.qty} × Rp ${formatRupiah(item.price)}</div>
                </div>
                <div class="font-semibold">Rp ${formatRupiah(item.subtotal)}</div>
            </div>
        `).join('');
        const total = cart.reduce((sum, item) => sum + item.subtotal, 0);

        checkoutPreview.innerHTML = `
            <div class="mb-4">
                <h3 class="text-lg font-semibold">Ringkasan Pesanan</h3>
            </div>
            ${rows}
            <div class="mt-4 text-right text-base font-semibold">Total Bayar: Rp ${formatRupiah(total)}</div>
        `;
    }

    async function submitOrder(event) {
        event.preventDefault();
        const cart = loadCart();
        if (!cart.length) {
            alert('Keranjang kosong. Tambahkan produk terlebih dahulu.');
            window.location.href = shopUrl;
            return;
        }

        const data = {
            nama_pemesan: document.getElementById('nama_pemesan').value.trim(),
            telepon: document.getElementById('telepon').value.trim(),
            email: document.getElementById('email').value.trim(),
            payment_method: document.getElementById('payment_method').value,
            note: document.getElementById('note').value.trim(),
            items: cart.map(item => ({produk_id: item.productId, qty: item.qty})),
        };

        if (!data.nama_pemesan || !data.telepon || !data.payment_method) {
            alert('Mohon lengkapi nama, telepon, dan metode pembayaran.');
            return;
        }

        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        try {
            const response = await fetch(checkoutUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data),
            });

            const json = await response.json();
            if (!response.ok || !json.success) {
                throw new Error(json.message || 'Gagal memproses pesanan');
            }

            localStorage.removeItem(CART_KEY);
            alert('Pesanan berhasil dibuat. Silakan cek Pesanan Saya.');
            window.location.href = orderHistoryUrl;
        } catch (error) {
            console.error(error);
            alert('Terjadi masalah saat mengirim pesanan. Coba lagi.');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        renderPreview();
        checkoutForm.addEventListener('submit', submitOrder);
    });
</script>
@endsection
