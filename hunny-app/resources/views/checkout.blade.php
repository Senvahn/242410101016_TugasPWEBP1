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
    <div class="content-wrapper">
        <div class="section-header">
            <h2>Checkout Pesanan</h2>
            <p>Lengkapi data pelanggan dan pilih metode pembayaran.</p>
        </div>

        <div class="card shadow-sm checkout-card">
        <div class="card-header">
            <div>
                <p class="eyebrow">Checkout Pesanan</p>
                <h3>Lengkapi data dan konfirmasi pesanan</h3>
            </div>
        </div>

        <div class="card-body">
            <div class="checkout-grid">
                <div class="checkout-form-panel">
                    <form id="checkoutForm" class="form-grid">
                        <div id="formError" class="form-group full-width" style="color:#c0392b; margin-bottom:16px;"></div>
                        <div class="main-data-grid full-width">
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
                                    <option value="bayar_di_toko">Bayar di Toko</option>
                                    <option value="qris">QRIS</option>
                                    <option value="e_wallet">E-Wallet (OVO / GoPay)</option>
                                </select>
                            </div>
                        </div>
                        <div id="paymentDetails" class="form-group full-width" style="display: none;">
                            <div id="qrisDetails" style="display: none;">
                                <label>Scan QR Code:</label>
                                <img src="{{ asset('images/payment/qris.jpg') }}" alt="QR Code QRIS" style="max-width: 200px;">
                            </div>
                            <div id="eWalletDetails" style="display: none;">
                                <label>Nomor E-Wallet:</label>
                                <p>081234567890 (OVO / GoPay)</p>
                            </div>
                            <div id="paymentProofGroup" style="display: none; margin-top: 12px;">
                                <label for="payment_proof">Upload Bukti Pembayaran</label>
                                <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept="image/*">
                                <small class="text-muted">Upload gambar bukti transfer / QRIS / e-wallet untuk admin cek.</small>
                                <div id="paymentProofError" class="form-error" style="color:#c0392b; margin-top:8px;"></div>
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label>Catatan Tambahan</label>
                            <textarea name="note" id="note" class="form-control" rows="4" placeholder="Permintaan khusus atau informasi tambahan..."></textarea>
                        </div>
                        <div class="form-actions full-width">
                            <button type="submit" class="btn btn-accent btn-block">Kirim Pesanan</button>
                        </div>
                    </form>
                </div>

                <div class="card shadow-sm summary-card">
                    <div class="card-header">
                        <h3>Ringkasan Pesanan</h3>
                    </div>
                    <div class="card-body" id="checkoutPreview">
                        <p class="preview-placeholder">Memuat ringkasan keranjang...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<style>
.content-wrapper { max-width: 1200px; margin: 0 auto; padding: 0 20px; box-sizing: border-box; }
.checkout-card { max-width: 900px; margin: 0 auto; }
.checkout-grid { display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 24px; align-items: start; width: 100%; }
.checkout-form-panel { min-width: 0; width: 100%; }
.form-grid { display: grid; gap: 18px; width: 100%; }
.main-data-grid { display: flex; flex-direction: column; gap: 1rem; width: 100%; }
.form-group { width: 100%; }
.form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
.form-control { width: 100%; box-sizing: border-box; padding: 12px 14px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.12); background: #f7f2eb; font-size: 1rem; }
.form-control::placeholder { color: #7b7b7b; }
.form-group.full-width { grid-column: 1 / -1; }
#paymentDetails { display: none; margin-top: 0; }
#paymentProofGroup { display: none; margin-top: 12px; }
.summary-card { background: rgba(255, 255, 255, 0.97); }
.summary-card .card-header { background: rgba(255, 255, 255, 0.98); }
.summary-row { display: flex; justify-content: space-between; align-items: center; gap: 14px; padding: 16px 0; border-bottom: 1px solid var(--border); }
.summary-row:last-child { border-bottom: none; }
.summary-item-name { color: var(--text); font-weight: 600; }
.summary-item-details { color: var(--text-muted); font-size: 0.88rem; }
.summary-total { margin-top: 16px; text-align: right; font-size: 1rem; font-weight: 700; color: var(--primary); }
.eyebrow { display: inline-block; margin-bottom: 8px; font-size: 0.78rem; letter-spacing: 0.18em; text-transform: uppercase; color: var(--accent); }
.form-actions { display: flex; justify-content: flex-end; margin-top: 14px; }
.preview-placeholder { color: var(--text-muted); font-size: 0.95rem; margin: 0; }
@media (max-width: 820px) {
    .checkout-grid { grid-template-columns: 1fr; }
    .main-data-grid { grid-template-columns: 1fr; }
    .form-actions { justify-content: center; }
    .form-control { font-size: 0.98rem; }
}
</style>
@endsection

@section('scripts')
<script>
    const CART_KEY = 'hunny_cart';
    const checkoutPreview = document.getElementById('checkoutPreview');
    const checkoutForm = document.getElementById('checkoutForm');
    let paymentProofInput;
    let paymentProofError;
    let formError;
    const checkoutUrl = '{{ route('checkout.process') }}';
    const shopUrl = '{{ route('shop.index') }}';
    const orderHistoryUrl = '{{ route('pesanan.saya') }}';

    function formatRupiah(number) {
        return Number(number).toLocaleString('id-ID');
    }

    function setFormError(message) {
        formError.textContent = message;
        formError.style.display = message ? 'block' : 'none';
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
            <div class="summary-row">
                <div>
                    <div class="summary-item-name">${item.name}</div>
                    <div class="summary-item-details">${item.qty} × Rp ${formatRupiah(item.price)}</div>
                </div>
                <div class="summary-item-name">Rp ${formatRupiah(item.subtotal)}</div>
            </div>
        `).join('');
        const total = cart.reduce((sum, item) => sum + item.subtotal, 0);

        checkoutPreview.innerHTML = `
            ${rows}
            <div class="summary-total">Total Bayar: Rp ${formatRupiah(total)}</div>
        `;
    }

    async function submitOrder(event) {
        event.preventDefault();
        setFormError('');
        paymentProofError.textContent = '';

        const cart = loadCart();
        if (!cart.length) {
            alert('Keranjang kosong. Tambahkan produk terlebih dahulu.');
            window.location.href = shopUrl;
            return;
        }

        const selectedMethod = document.getElementById('payment_method').value;
        if ((selectedMethod === 'qris' || selectedMethod === 'e_wallet') && !paymentProofInput.files.length) {
            paymentProofError.textContent = 'Bukti pembayaran wajib diunggah untuk QRIS / E-Wallet.';
            paymentProofInput.focus();
            return;
        }

        const formData = new FormData(checkoutForm);
        cart.forEach((item, index) => {
            formData.append(`items[${index}][produk_id]`, item.productId);
            formData.append(`items[${index}][qty]`, item.qty);
        });

        const data = {
            nama_pemesan: formData.get('nama_pemesan')?.toString().trim() || '',
            telepon: formData.get('telepon')?.toString().trim() || '',
            email: formData.get('email')?.toString().trim() || '',
            payment_method: formData.get('payment_method')?.toString() || '',
            note: formData.get('note')?.toString().trim() || '',
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
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: formData,
            });

            const json = await response.json();
            if (!response.ok || !json.success) {
                if (json.errors) {
                    if (json.errors.payment_proof) {
                        paymentProofError.textContent = json.errors.payment_proof.join(' ');
                    } else {
                        setFormError(Object.values(json.errors).flat().join(' '));
                    }
                } else {
                    setFormError(json.message || 'Gagal memproses pesanan.');
                }
                return;
            }

            localStorage.removeItem(CART_KEY);
            alert('Pesanan berhasil dibuat. Silakan cek Pesanan Saya.');
            window.location.href = orderHistoryUrl;
        } catch (error) {
            console.error(error);
            if (!formError.textContent) {
                setFormError('Terjadi masalah saat mengirim pesanan. Coba lagi.');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const userName = @json(auth()->user()->name);
        const userEmail = @json(auth()->user()->email);

        document.getElementById('nama_pemesan').value = userName;
        document.getElementById('email').value = userEmail;
        paymentProofInput = document.getElementById('payment_proof');
        paymentProofError = document.getElementById('paymentProofError');
        formError = document.getElementById('formError');

        renderPreview();
        checkoutForm.addEventListener('submit', submitOrder);

        const paymentMethodSelect = document.getElementById('payment_method');
        const paymentDetails = document.getElementById('paymentDetails');
        const qrisDetails = document.getElementById('qrisDetails');
        const eWalletDetails = document.getElementById('eWalletDetails');
        const paymentProofGroup = document.getElementById('paymentProofGroup');

        paymentMethodSelect.addEventListener('change', function () {
            const selectedMethod = paymentMethodSelect.value;

            const showProof = selectedMethod === 'qris' || selectedMethod === 'e_wallet';

            if (selectedMethod === 'qris') {
                paymentDetails.style.display = 'block';
                qrisDetails.style.display = 'block';
                eWalletDetails.style.display = 'none';
            } else if (selectedMethod === 'e_wallet') {
                paymentDetails.style.display = 'block';
                qrisDetails.style.display = 'none';
                eWalletDetails.style.display = 'block';
            } else {
                paymentDetails.style.display = 'none';
                qrisDetails.style.display = 'none';
                eWalletDetails.style.display = 'none';
            }

            paymentProofGroup.style.display = showProof ? 'block' : 'none';
            paymentProofInput.required = showProof;
            if (!showProof) {
                paymentProofError.textContent = '';
            }
        });

        paymentMethodSelect.dispatchEvent(new Event('change'));

        paymentMethodSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection
