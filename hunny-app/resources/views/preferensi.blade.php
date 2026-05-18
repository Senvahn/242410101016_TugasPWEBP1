@extends('layouts.customer')

@section('title', 'Preferensi')

@section('content')
<div class="breadcrumb" style="margin-bottom: 24px;">
    <a href="{{ url('/') }}">Beranda</a>
    <i class="fas fa-chevron-right"></i>
    <span>Preferensi</span>
</div>

<div class="cust-container">
    <div class="section-header">
        <h2>Pengaturan Preferensi</h2>
        <p>Atur tema dan ukuran teks untuk pengalaman yang lebih nyaman.</p>
    </div>

    <div class="card shadow-sm" style="max-width: 760px; margin: 0 auto;">
        <div class="p-6">
            <form id="preferencesForm" class="space-y-5">
                <div class="form-group">
                    <label for="theme">Tema</label>
                    <select id="theme" name="theme" class="form-control">
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                        <option value="system">System</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="font_size">Ukuran Font</label>
                    <select id="font_size" name="font_size" class="form-control">
                        <option value="small">Kecil</option>
                        <option value="medium">Sedang</option>
                        <option value="large">Besar</option>
                    </select>
                </div>

                <div class="form-actions" style="justify-content:flex-end; gap: 12px; margin-top: 16px; flex-wrap: wrap;">
                    <button type="submit" class="btn btn-accent">Simpan Preferensi</button>
                    <form method="POST" action="{{ route('preferensi.reset') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Reset Hitungan</button>
                    </form>
                </div>
            </form>

            <div class="mt-6 rounded-lg bg-slate-50 dark:bg-slate-800 p-4 border border-slate-200 dark:border-slate-700">
                <h3 class="text-lg font-semibold mb-3">Statistik Kunjungan Halaman</h3>
                <div class="space-y-2 text-sm text-slate-700 dark:text-slate-300">
                    <p><strong>Jumlah kunjungan:</strong> {{ $visitCount ?? 1 }}</p>
                    <p><strong>Waktu kunjungan pertama:</strong> {{ $firstVisit ?? now()->format('d M Y H:i:s') }}</p>
                    <p><strong>Waktu kunjungan terakhir:</strong> {{ $lastVisit ?? now()->format('d M Y H:i:s') }}</p>
                </div>
            </div>

            <div id="preferencesStatus" class="mt-4 text-sm text-gray-600"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const preferencesForm = document.getElementById('preferencesForm');
        const themeSelect = document.getElementById('theme');
        const fontSizeSelect = document.getElementById('font_size');
        const statusText = document.getElementById('preferencesStatus');

        themeSelect.value = @json($theme);
        fontSizeSelect.value = @json($fontSize);

        preferencesForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            const body = {
                theme: themeSelect.value,
                font_size: fontSizeSelect.value,
            };

            const token = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch('{{ route('preferensi.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(body),
                });

                const json = await response.json();
                if (!response.ok || !json.success) {
                    throw new Error(json.message || 'Gagal menyimpan preferensi');
                }

                statusText.textContent = 'Preferensi berhasil disimpan.';
                statusText.style.color = '#2f855a';

                if (typeof applyTheme === 'function') {
                    applyTheme(body.theme);
                }
                if (typeof applyFontSize === 'function') {
                    applyFontSize(body.font_size);
                }
            } catch (error) {
                console.error(error);
                statusText.textContent = 'Terjadi kesalahan saat menyimpan preferensi. Coba lagi.';
                statusText.style.color = '#c53030';
            }
        });
    });
</script>
@endsection
