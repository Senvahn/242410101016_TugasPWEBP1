@extends('layouts.app')

@section('content')
<div class="w-full min-h-screen bg-[#f9f7f4] py-8 px-4 sm:px-6 lg:px-8 text-[#3d2817]">
    <div class="max-w-7xl mx-auto">

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center gap-2 text-sm">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-[#3d2817] flex items-center gap-2">
                    🐾 Daftar Reservasi Grooming
                </h1>
                <p class="text-xs text-gray-500 mt-1">Total: {{ $bookings->total() }} reservasi</p>
            </div>
            <div>
                <a href="{{ route('booking.create') }}"
                   class="inline-block bg-[#3d2817] hover:bg-[#543922] text-white px-4 py-2 rounded-xl text-sm font-medium transition shadow-sm">
                    + Tambah Reservasi
                </a>
            </div>
        </div>

        {{-- Search Form --}}
        <div class="mb-6 bg-white rounded-2xl border border-[#e8dcc8] p-4 shadow-sm">
            <form id="bookingSearchForm" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <input
                    type="text"
                    name="query"
                    id="bookingSearchInput"
                    placeholder="Cari reservasi: nama, kode, hewan..."
                    class="w-full bg-[#fefdfb] border border-[#e8dcc8] rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#e8dcc8] text-[#3d2817]"
                />
                <button
                    type="submit"
                    class="w-full sm:w-auto bg-[#3d2817] hover:bg-[#543922] text-white px-6 py-2.5 rounded-xl text-sm font-medium transition"
                >Cari</button>
            </form>
            <p id="bookingSearchStatus" class="text-xs text-gray-400 mt-2">Ketik kata kunci lalu tekan Cari untuk memuat hasil tanpa refresh.</p>
        </div>

        {{-- Hasil Pencarian AJAX --}}
        <div id="bookingSearchResults" class="hidden mb-6 bg-white rounded-2xl border border-[#e8dcc8] overflow-hidden shadow-sm">
            <div class="px-4 py-3 bg-[#fbfaf8] border-b border-[#e8dcc8]">
                <h2 class="text-sm font-semibold text-[#3d2817]">Hasil Pencarian</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <tbody id="bookingSearchResultsBody" class="divide-y divide-[#f4eee4]"></tbody>
                </table>
            </div>
        </div>

        {{-- Tabel Utama --}}
        <div class="bg-white rounded-2xl border border-[#e8dcc8] overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left mt-0">
                    <thead class="bg-[#f4eee4] text-[#3d2817] uppercase text-xs font-bold border-b border-[#e8dcc8]">
                        <tr>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Nama Pemilik</th>
                            <th class="px-4 py-3">Hewan</th>
                            <th class="px-4 py-3">Layanan</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f4eee4]">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-[#fbfaf8] transition">
                            <td class="px-4 py-3.5 font-mono font-bold text-[#b8860b]">{{ $booking->kode_booking }}</td>
                            <td class="px-4 py-3.5 font-medium text-[#3d2817]">
                                {{ $booking->nama_pemilik }}
                            </td>
                            <td class="px-4 py-3.5 text-gray-600">
                                {{ $booking->nama_hewan }} <span class="text-xs text-gray-400">({{ $booking->jenis_hewan }})</span>
                            </td>
                            <td class="px-4 py-3.5 text-gray-600">{{ $booking->jenis_layanan ?? $booking->layanan }}</td>
                            <td class="px-4 py-3.5 text-gray-600">
                                {{ isset($booking->tanggal_reservasi) ? \Carbon\Carbon::parse($booking->tanggal_reservasi)->format('d M Y') : ($booking->tanggal ?? '-') }}
                            </td>
                            <td class="px-4 py-3.5">
                                @php
                                    $statusColor = [
                                        'pending'   => 'bg-amber-50 text-amber-800 border-amber-200',
                                        'confirmed' => 'bg-blue-50 text-blue-800 border-blue-200',
                                        'done'      => 'bg-green-50 text-green-800 border-green-200',
                                        'cancelled' => 'bg-red-50 text-red-800 border-red-200',
                                    ][strtolower($booking->status)] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $statusColor }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <a href="{{ route('booking.show', $booking) }}"
                                   class="text-[#b8860b] hover:text-[#3d2817] text-xs font-bold hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-gray-400">
                                <div class="text-3xl mb-2">🐾</div>
                                Belum ada data reservasi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $bookings->links() }}
        </div>
    </div>
</div>

<script>
    function renderSearchRows(bookings) {
        return bookings.map(booking => {
            const statusClasses = {
                pending: 'bg-amber-50 text-amber-800 border-amber-200 border',
                confirmed: 'bg-blue-50 text-blue-800 border-blue-200 border',
                done: 'bg-green-50 text-green-800 border-green-200 border',
                cancelled: 'bg-red-50 text-red-800 border-red-200 border',
            };
            const statusClass = statusClasses[booking.status.toLowerCase()] || 'bg-gray-50 text-gray-700 border border-gray-200';
            return `
                <tr class="hover:bg-[#fbfaf8] transition">
                    <td class="px-4 py-3.5 font-mono font-bold text-[#b8860b]">${booking.kode_booking}</td>
                    <td class="px-4 py-3.5 font-medium text-[#3d2817]">${booking.nama_pemilik}</td>
                    <td class="px-4 py-3.5 text-gray-600">${booking.nama_hewan} <span class="text-xs text-gray-400">(${booking.jenis_hewan})</span></td>
                    <td class="px-4 py-3.5 text-gray-600">${booking.jenis_layanan || booking.layanan}</td>
                    <td class="px-4 py-3.5 text-gray-600">${booking.tanggal_reservasi || booking.tanggal}</td>
                    <td class="px-4 py-3.5">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold ${statusClass}">
                            ${booking.status.charAt(0).toUpperCase() + booking.status.slice(1)}
                        </span>
                    </td>
                </tr>
            `;
        }).join('');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('bookingSearchForm');
        const input = document.getElementById('bookingSearchInput');
        const status = document.getElementById('bookingSearchStatus');
        const resultsContainer = document.getElementById('bookingSearchResults');
        const resultsBody = document.getElementById('bookingSearchResultsBody');
        const token = document.querySelector('meta[name="csrf-token"]')?.content;

        if(form) {
            form.addEventListener('submit', async function (event) {
                event.preventDefault();
                const query = input.value.trim();

                if (!query) {
                    resultsBody.innerHTML = '';
                    resultsContainer.classList.add('hidden');
                    status.textContent = 'Isi kata kunci pencarian terlebih dahulu.';
                    return;
                }

                status.textContent = 'Mencari reservasi...';
                resultsContainer.classList.remove('hidden');
                resultsBody.innerHTML = '<tr><td colspan="6" class="px-4 py-4 text-gray-500 text-center">Memuat hasil...</td></tr>';

                try {
                    const response = await fetch('{{ route('booking.search') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ query }),
                    });

                    if (!response.ok) throw new Error('Gagal memuat data');

                    const json = await response.json();
                    const bookings = json.data || [];

                    if (bookings.length === 0) {
                        resultsBody.innerHTML = '<tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Tidak ada hasil pencarian.</td></tr>';
                        status.textContent = `Tidak ditemukan hasil untuk "${query}".`;
                    } else {
                        resultsBody.innerHTML = renderSearchRows(bookings);
                        status.textContent = `Menampilkan ${bookings.length} hasil untuk "${query}".`;
                    }
                } catch (error) {
                    resultsBody.innerHTML = '<tr><td colspan="6" class="px-4 py-8 text-center text-red-500">Terjadi kesalahan. Coba lagi.</td></tr>';
                    status.textContent = 'Terjadi problem saat memuat pencarian.';
                }
            });
        }
    });
</script>
@endsection