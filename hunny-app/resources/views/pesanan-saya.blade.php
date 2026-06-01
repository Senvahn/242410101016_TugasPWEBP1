@extends('layouts.customer')

@section('title', 'Pesanan Saya')

@section('content')
<div class="breadcrumb">
    <a href="{{ url('/') }}">Beranda</a>
    <i class="fas fa-chevron-right"></i>
    <a href="{{ url('/customer') }}">Toko</a>
    <i class="fas fa-chevron-right"></i>
    <span>Pesanan Saya</span>
</div>

<div class="cust-container main-content-wrapper">
    <section class="page-shell">
        <header class="hero-card">
            <div>
                <p class="eyebrow">Pesanan Saya</p>
                <h2>Lacak pesanan dengan cepat</h2>
                <p class="lede">Masukkan nomor telepon atau kode pesanan untuk melihat status terkini dan detail lengkapnya.</p>
            </div>
            <div class="hero-badges">
                <span><i class="fas fa-shield-alt"></i> Aman & cepat</span>
                <span><i class="fas fa-clock"></i> Update real-time</span>
                <span><i class="fas fa-box-open"></i> Detail lengkap</span>
            </div>
        </header>

        <section class="panel-card search-panel">
            <div class="search-copy">
                <h3>Cari Pesanan Anda</h3>
                <p>Gunakan nomor telepon atau kode pesanan untuk menampilkan status terbaru.</p>
            </div>
            <div class="search-box-wa">
                <input type="text" id="querySearch" placeholder="Nomor telepon / kode pesanan" class="form-control" autocomplete="off">
                <button class="btn btn-accent" id="searchButton" type="button">Cari Pesanan</button>
            </div>
        </section>

        <section id="orderList" class="order-grid" aria-live="polite">
            <article class="empty-state-big">
                <i class="fas fa-search"></i>
                <h3>Mulai pencarian pesanan</h3>
                <p>Gunakan nomor telepon atau kode pesanan untuk menampilkan hasil terbaru.</p>
            </article>
        </section>
    </section>
</div>

<!-- Modal Detail Pesanan -->
<div id="orderDetailModal" class="modal-overlay">
    <div class="modal-content order-detail-modal">
        <div class="modal-header">
            <h2 id="modalOrderCode">Detail Pesanan</h2>
            <button class="modal-close-btn" onclick="closeOrderDetail()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="modalBody">
            <p>Memuat detail pesanan...</p>
        </div>
    </div>
</div>

<style>
.main-content-wrapper {
    margin-top: 96px;
    padding-bottom: 60px;
}
.page-shell {
    display: grid;
    gap: 24px;
}
.cust-container {
    max-width: 1180px;
    width: min(100%, 1180px);
    margin: 0 auto;
    padding: 0 18px;
}
.hero-card,
.panel-card,
.order-status-card,
.modal-content {
    border: 1px solid rgba(143, 118, 71, 0.16);
    border-radius: 24px;
    background: var(--surface, #fff);
    box-shadow: 0 18px 40px rgba(20, 24, 28, 0.08);
}
.hero-card {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 18px;
    padding: 26px;
    background:
        linear-gradient(135deg, rgba(255, 255, 255, 0.98), rgba(251, 247, 241, 0.94)),
        linear-gradient(135deg, rgba(201, 137, 74, 0.14), rgba(255, 255, 255, 0));
}
.eyebrow {
    text-transform: uppercase;
    letter-spacing: 0.18em;
    font-size: 0.78rem;
    color: var(--accent, #c9894a);
    font-weight: 700;
    margin-bottom: 8px;
}
.hero-card h2 {
    margin: 0 0 8px;
    font-size: clamp(1.6rem, 4vw, 2.15rem);
    color: var(--primary, #2e372c);
}
.lede {
    color: var(--text-muted, #6f766f);
    margin: 0;
    max-width: 640px;
}
.hero-badges {
    display: grid;
    gap: 10px;
    align-content: start;
}
.hero-badges span {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    border-radius: 14px;
    background: rgba(255, 255, 255, 0.88);
    border: 1px solid rgba(143, 118, 71, 0.14);
    color: var(--primary, #2e372c);
    font-weight: 600;
}
.panel-card {
    padding: 20px;
}
.search-panel {
    display: grid;
    gap: 16px;
}
.search-copy h3 {
    margin: 0 0 6px;
    font-size: 1.05rem;
    color: var(--primary, #2e372c);
}
.search-copy p {
    margin: 0;
    color: var(--text-muted, #6f766f);
    font-size: 0.96rem;
}
.search-box-wa {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 12px;
    align-items: center;
}
.search-box-wa input {
    min-width: 0;
    border-radius: 14px;
    border: 1px solid rgba(143, 118, 71, 0.18);
    padding: 12px 14px;
    background: rgba(255, 255, 255, 0.95);
}
.order-grid {
    display: grid;
    gap: 18px;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
}
.order-status-card {
    overflow: hidden;
    cursor: pointer;
    transition: transform .18s ease, box-shadow .18s ease;
}
.order-status-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 18px 38px rgba(20, 24, 28, 0.12);
}
.order-card-top {
    display: flex;
    justify-content: space-between;
    gap: 14px;
    padding: 18px 18px 12px;
}
.order-kode,
.order-waktu,
.order-meta span {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-muted, #6f766f);
    font-size: 0.92rem;
}
.order-kode code {
    background: rgba(201, 137, 74, 0.12);
    color: var(--primary, #2e372c);
    border-radius: 999px;
    padding: 4px 8px;
    font-size: 0.82rem;
}
.order-card-body {
    padding: 0 18px 18px;
}
.order-total-badge {
    font-family: 'Playfair Display', serif;
    font-size: 1.18rem;
    font-weight: 700;
    color: var(--accent, #c9894a);
    text-align: right;
    white-space: nowrap;
}
.status-badge {
    display: inline-flex;
    align-items: center;
    border-radius: 999px;
    padding: 6px 10px;
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: capitalize;
    background: rgba(201, 137, 74, 0.12);
    color: var(--accent, #c9894a);
}
.status-badge.status-cancelled,
.status-badge.status-canceled { background: rgba(220, 53, 69, 0.12); color: #b42318; }
.status-badge.status-done,
.status-badge.status-selesai { background: rgba(40, 167, 69, 0.12); color: #1b7a41; }
.status-badge.status-shipping,
.status-badge.status-dikirim { background: rgba(13, 110, 253, 0.12); color: #1e5fd6; }
.empty-state-big {
    display: grid;
    place-items: center;
    text-align: center;
    gap: 8px;
    padding: 28px;
    border-radius: 24px;
    border: 1px dashed rgba(143, 118, 71, 0.25);
    background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(251,247,241,0.92));
    color: var(--text-muted, #6f766f);
}
.empty-state-big i { font-size: 1.8rem; color: var(--accent, #c9894a); }
.empty-state-big h3 { margin: 0; color: var(--primary, #2e372c); }
.empty-state-big p { margin: 0; max-width: 420px; }

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(14, 18, 22, 0.52);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 18px;
    z-index: 1100;
}
.modal-overlay.is-open { display: flex; }
.modal-content {
    width: min(900px, 100%);
    max-height: 86vh;
    overflow: auto;
}
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    padding: 18px 20px;
    border-bottom: 1px solid rgba(143, 118, 71, 0.14);
    background: linear-gradient(135deg, rgba(201, 137, 74, 0.12), rgba(255,255,255,0));
}
.modal-header h2 { margin: 0; font-size: 1.18rem; color: var(--primary, #2e372c); }
.modal-close-btn {
    border: none;
    background: rgba(143, 118, 71, 0.08);
    border-radius: 999px;
    width: 36px;
    height: 36px;
    display: grid;
    place-items: center;
    color: var(--text-muted, #6f766f);
    cursor: pointer;
}
.modal-body { padding: 20px; }
.detail-section { margin-bottom: 18px; }
.detail-section-title {
    display: block;
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.14em;
    color: var(--accent, #c9894a);
    font-weight: 700;
    margin-bottom: 10px;
}
.detail-row {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid rgba(143, 118, 71, 0.08);
}
.detail-row:last-child { border-bottom: none; }
.detail-label { color: var(--text-muted, #6f766f); font-size: 0.92rem; }
.detail-value { font-weight: 600; color: var(--primary, #2e372c); text-align: right; }
.items-list.simple-items {
    display: block;
    padding: 0;
    background: none;
    border: none;
}
.item-row.simple-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0 0 2px 0;
    border: none;
    background: none;
}
.item-name { font-weight: 600; color: var(--primary, #2e372c); }
.item-meta { color: var(--text-muted, #6f766f); font-size: 0.97em; }
.item-price { font-weight: 600; color: var(--accent, #c9894a); margin-left: auto; }
.total-section {
    padding: 14px;
    border-radius: 18px;
    background: linear-gradient(135deg, rgba(201, 137, 74, 0.13), rgba(255,255,255,0));
}
.total-row { display:flex; justify-content:space-between; gap:12px; align-items:center; font-weight:700; color:var(--primary, #2e372c); }

@media (max-width: 920px) {
    .hero-card { grid-template-columns: 1fr; }
}
@media (max-width: 720px) {
    .main-content-wrapper { margin-top: 82px; }
    .search-box-wa { grid-template-columns: 1fr; }
    .order-card-top { flex-direction: column; align-items: flex-start; }
    .order-total-badge { text-align: left; }
    .detail-row { flex-direction: column; align-items: flex-start; }
    .detail-value { text-align: left; }
    .modal-content { max-height: 92vh; }
}
</style>

@section('scripts')
<script>
    const searchUrl = '{{ route('orders.search') }}';
    const orderDetailUrl = '{{ route('orders.detail', ':id') }}';
    const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

    function formatRupiah(number) {
        return Number(number).toLocaleString('id-ID');
    }

    function formatDateTime(dateStr) {
        if (!dateStr) return '-';
        const date = new Date(dateStr);
        return date.toLocaleString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#39;');
    }

    function renderEmptyState(message) {
        const container = document.getElementById('orderList');
        container.innerHTML = `
            <div class="empty-state-big">
                <i class="fas fa-search"></i>
                <h3>${message.title}</h3>
                <p>${message.detail}</p>
            </div>`;
    }

    function closeOrderDetail() {
        const modal = document.getElementById('orderDetailModal');
        if (modal) {
            modal.classList.remove('is-open');
            modal.style.display = 'none';
            console.log('Modal closed');
        }
    }

    function renderOrderDetail(order) {
        const modal = document.getElementById('orderDetailModal');
        const modalBody = document.getElementById('modalBody');
        const modalHeader = document.getElementById('modalOrderCode');

        if (!modal || !modalBody || !modalHeader) {
            console.error('Modal elements not found!');
            alert('Terjadi kesalahan: Modal elements tidak ditemukan');
            return;
        }

        const normalizedItems = Array.isArray(order.items) && order.items.length
            ? order.items
            : [];
        const statusClass = String(order.status || 'pending').toLowerCase().replace(/\s/g, '-');
        const itemsHtml = normalizedItems.length
            ? normalizedItems.map(item => `
                <div class="item-row">
                    <div class="item-info">
                        <div class="item-name">${escapeHtml(item.name || item.nama_barang || 'Produk')}</div>
                        <div class="item-meta">${Number(item.qty || 1)} × Rp ${formatRupiah(item.price || item.unit_price || item.harga_beli || 0)}</div>
                    </div>
                    <div class="item-price">Rp ${formatRupiah(item.subtotal || item.sub_total || (Number(item.qty || 1) * Number(item.price || item.unit_price || 0)))}</div>
                </div>
            `).join('')
            : '<p style="color: var(--text-muted);">Item tidak ditemukan</p>';

        modalHeader.innerHTML = `${escapeHtml(order.order_code || 'Detail Pesanan')} <span style="font-size: 0.7rem; color: var(--text-muted);">Detail Pesanan</span>`;
        modalBody.innerHTML = `
            <div class="detail-section">
                <span class="detail-section-title">Informasi Pemesan</span>
                <div class="detail-row">
                    <span class="detail-label">Nama</span>
                    <span class="detail-value">${escapeHtml(order.nama_pemesan || '-')}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Telepon</span>
                    <span class="detail-value">${escapeHtml(order.telepon || '-')}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">${escapeHtml(order.email || '-')}</span>
                </div>
            </div>

            <div class="detail-section">
                <span class="detail-section-title">Item Pesanan</span>
                <div class="items-list">${itemsHtml}</div>
            </div>

            <div class="detail-section">
                <span class="detail-section-title">Detail Transaksi</span>
                <div class="detail-row">
                    <span class="detail-label">Tanggal & Waktu Pesanan</span>
                    <span class="detail-value">${formatDateTime(order.created_at)}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Metode Pembayaran</span>
                    <span class="detail-value">${escapeHtml(order.payment_method || 'Bayar di Toko')}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status Pesanan</span>
                    <span class="detail-value"><span class="status-badge status-${statusClass}">${escapeHtml(order.status || 'pending')}</span></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Catatan</span>
                    <span class="detail-value">${escapeHtml(order.note || '-')}</span>
                </div>
            </div>

            <div class="total-section">
                <div class="total-row">
                    <span>Total Pembayaran:</span>
                    <span>Rp ${formatRupiah(order.total || 0)}</span>
                </div>
            </div>
        `;

        modal.classList.add('is-open');
        modal.style.display = 'flex';
    }

    async function openOrderDetail(orderId) {
        console.log('openOrderDetail called with ID:', orderId);

        const modal = document.getElementById('orderDetailModal');
        const modalBody = document.getElementById('modalBody');
        const modalHeader = document.getElementById('modalOrderCode');

        if (!modal || !modalBody || !modalHeader) {
            console.error('Modal elements not found!');
            alert('Terjadi kesalahan: Modal elements tidak ditemukan');
            return;
        }

        modalHeader.innerHTML = 'Memuat Detail...';
        modalBody.innerHTML = '<p style="color: var(--text-muted); text-align: center;">Memuat detail pesanan...</p>';
        modal.classList.add('is-open');
        modal.style.display = 'flex';

        try {
            const url = orderDetailUrl.replace(':id', orderId);
            const response = await fetch(url, { headers: { 'Accept': 'application/json' } });

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.error || `HTTP Error ${response.status}`);
            }

            const json = await response.json();
            const order = json.data;

            if (!order) {
                throw new Error('Data pesanan tidak ditemukan');
            }

            renderOrderDetail(order);
        } catch (error) {
            console.error('Error loading order detail:', error);
            modalHeader.innerHTML = `Error`;
            modalBody.innerHTML = `
                <div style="text-align: center; padding: 20px;">
                    <p style="color: #d32f2f; margin-bottom: 20px;">
                        <i class="fas fa-exclamation-circle" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                        Gagal memuat detail pesanan
                    </p>
                    <p style="color: var(--text-muted); margin-bottom: 20px;">
                        ${error.message}
                    </p>
                    <button onclick="closeOrderDetail()" style="background: var(--accent); color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; width: 100%; max-width: 150px;">
                        Tutup
                    </button>
                </div>
            `;
        }
    }

    function renderOrders(orders) {
        const container = document.getElementById('orderList');

        if (!orders.length) {
            container.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-times-circle fa-3x"></i>
                    <p>Pesanan tidak ditemukan. Periksa kembali nomor telepon atau kode pesanan.</p>
                </div>`;
            return;
        }


        container.innerHTML = orders.map(order => {
            const statusClass = String(order.status || 'pending').toLowerCase().replace(/\s/g, '-');
            const contact = order.telepon || order.email || 'Tanpa kontak';
            const formattedTotal = Number(order.total || 0).toLocaleString('id-ID');
            const formattedDate = formatDateTime(order.created_at);
            const safeCode = escapeHtml(order.order_code || '');
            const safeNama = escapeHtml(order.nama_pemesan || '');
            const safeContact = escapeHtml(contact);
            const safeStatus = escapeHtml(order.status || 'pending');
            const safePayment = escapeHtml(order.payment_method || 'Bayar di Toko');
            const safeDate = escapeHtml(formattedDate);
            const safeTotal = escapeHtml(formattedTotal);
            const safeItems = escapeHtml(JSON.stringify(order.items || []));

            // Render item list directly in card
            let itemsHtml = '';
            let totalHtml = '';
            let items = [];
            try { items = JSON.parse(order.items && typeof order.items === 'string' ? order.items : JSON.stringify(order.items || [])); } catch { items = []; }
            if (Array.isArray(items) && items.length) {
                itemsHtml = `<ul class='items-list simple-items' style='margin: 12px 0 0 0; padding:0; background:none; border:none;'>` +
                    items.map(item => `
                        <li class='item-row simple-row' style='display:flex;align-items:center;gap:10px;padding:0 0 2px 0;border:none;background:none;'>
                            <span class='item-name' style='font-weight:600;color:var(--primary,#2e372c);'>${escapeHtml(item.name || item.nama_barang || 'Produk')}</span>
                            <span class='item-meta' style='color:var(--text-muted,#6f766f);font-size:0.97em;'>${Number(item.qty || 1)} × Rp ${formatRupiah(item.price || item.unit_price || item.harga_beli || 0)}</span>
                            <span class='item-price' style='margin-left:auto;font-weight:600;color:var(--accent,#c9894a);'>Rp ${formatRupiah(item.subtotal || item.sub_total || (Number(item.qty || 1) * Number(item.price || item.unit_price || 0)))}</span>
                        </li>
                    `).join('') + `</ul>`;
                totalHtml = `<div class='total-section' style='margin-top:8px;padding:8px 0 0 0;background:none;'><div class='total-row' style='font-size:1.07em;'><span>Total:</span><span style='color:var(--accent,#c9894a);font-weight:700;'>Rp ${formatRupiah(order.total || 0)}</span></div></div>`;
            } else {
                itemsHtml = `<div class='items-list simple-items' style='margin: 12px 0 0 0;'><span style='color:var(--text-muted);font-size:0.95em;'>Tidak ada item</span></div>`;
            }

            return `
                <div class="order-status-card shadow-sm"
                    data-order-id="${escapeHtml(String(order.id || ''))}"
                    data-order-code="${safeCode}"
                    data-nama-pemesan="${safeNama}"
                    data-telepon="${escapeHtml(order.telepon || '')}"
                    data-email="${escapeHtml(order.email || '')}"
                    data-payment="${safePayment}"
                    data-status="${safeStatus}"
                    data-total="${Number(order.total || 0)}"
                    data-created-at="${escapeHtml(order.created_at || '')}"
                    data-items='${safeItems}'>
                    <div class="order-card-top">
                        <div>
                            <div class="order-kode"><i class="fas fa-box-open"></i><code>${safeCode}</code></div>
                            <div class="order-waktu"><i class="fas fa-calendar-alt"></i> ${safeDate}</div>
                            <div class="order-meta">
                                <span><i class="fas fa-user"></i> ${safeNama}</span>
                                <span><i class="fas fa-phone"></i> ${safeContact}</span>
                            </div>
                        </div>
                        <div class="order-total-badge">Rp ${safeTotal}</div>
                    </div>
                    <div class="order-card-body">
                        <div class="status-badge status-${statusClass}">${safeStatus}</div>
                        <div class="order-meta" style="margin-top: 16px;">
                            <span><i class="fas fa-credit-card"></i> ${safePayment}</span>
                        </div>
                        ${itemsHtml}
                        ${totalHtml}
                    </div>
                </div>
            `;
        }).join('');

        // Delegated click handler so dynamically rendered cards stay interactive.
        if (!container.dataset.cardBound) {
            container.addEventListener('click', (event) => {
                const card = event.target.closest('.order-status-card');
                if (!card) return;

                const orderId = card.getAttribute('data-order-id');
                if (!orderId) return;

                const order = {
                    id: orderId,
                    order_code: card.dataset.orderCode || 'Pesanan',
                    nama_pemesan: card.dataset.namaPemesan || '-',
                    telepon: card.dataset.telepon || '-',
                    email: card.dataset.email || '-',
                    payment_method: card.dataset.payment || 'Bayar di Toko',
                    status: card.dataset.status || 'pending',
                    total: Number(card.dataset.total || 0),
                    created_at: card.dataset.createdAt || '',
                    items: (() => {
                        try { return JSON.parse(card.dataset.items || '[]'); }
                        catch (error) { console.warn('Invalid order items data', error); return []; }
                    })(),
                    note: ''
                };

                console.log('Card clicked, order ID:', orderId);
                renderOrderDetail(order);
            });
            container.dataset.cardBound = 'true';
        }
    }

    async function fetchOrders(query = '') {
        if (!query && !isAuthenticated) {
            renderEmptyState({
                title: 'Mulai pencarian pesanan',
                detail: 'Masukkan nomor telepon atau kode pesanan, lalu tekan Cari.'
            });
            return;
        }

        const url = new URL(searchUrl, window.location.origin);
        if (query) {
            url.searchParams.set('query', query);
        }

        const response = await fetch(url.toString(), {
            headers: { 'Accept': 'application/json' }
        });
        const json = await response.json();
        renderOrders(json.data || []);
    }

    document.getElementById('searchButton').addEventListener('click', () => {
        const query = document.getElementById('querySearch').value.trim();
        fetchOrders(query);
    });

    document.getElementById('querySearch').addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            document.getElementById('searchButton').click();
        }
    });

    // Close modal when clicking outside
    document.getElementById('orderDetailModal').addEventListener('click', (e) => {
        if (e.target.id === 'orderDetailModal') {
            closeOrderDetail();
        }
    });

    // Close modal on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeOrderDetail();
        }
    });

    if (isAuthenticated) {
        fetchOrders();
    }
</script>
@endsection