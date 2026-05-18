@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-800 rounded-lg flex items-center gap-2">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-100 border border-red-400 text-red-800 rounded-lg flex items-center gap-2">
            <span>❌</span> {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">🐾 Daftar Reservasi Grooming</h1>
            <p class="text-sm text-gray-500 mt-1">Total: {{ $bookings->total() }} reservasi</p>
        </div>
        <a href="{{ route('booking.create') }}"
           class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            + Tambah Reservasi
        </a>
    </div>

    {{-- Search Form --}}
    <div class="mb-6 bg-white rounded-xl shadow p-4">
        <form id="bookingSearchForm" class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <input
                type="text"
                name="query"
                id="bookingSearchInput"
                placeholder="Cari reservasi: nama, kode, hewan, email"
                class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:border-pink-300 focus:ring-2 focus:ring-pink-100"
            />
            <button
                type="submit"
                class="w-full sm:w-auto bg-pink-500 hover:bg-pink-600 text-white px-4 py-3 rounded-lg font-medium transition"
            >Cari</button>
        </form>
        <p id="bookingSearchStatus" class="text-xs text-gray-500 mt-2">Ketik kata kunci lalu tekan Cari untuk memuat hasil tanpa refresh.</p>
    </div>

    <div id="bookingSearchResults" class="hidden mb-6">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-4 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-800">Hasil Pencarian</h2>
            </div>
            <table class="w-full text-sm text-left">
                <thead class="bg-pink-50 text-pink-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Nama Pemilik</th>
                        <th class="px-4 py-3">Hewan</th>
                        <th class="px-4 py-3">Layanan</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody id="bookingSearchResultsBody" class="divide-y divide-gray-100"></tbody>
            </table>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-pink-50 text-pink-700 uppercase text-xs">
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
            <tbody class="divide-y divide-gray-100">
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-mono font-semibold text-pink-600">{{ $booking->kode_booking }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            @if($booking->foto_hewan)
                                <img src="{{ asset('storage/' . $booking->foto_hewan) }}"
                                     class="w-8 h-8 rounded-full object-cover border border-pink-200">
                            @else
                                <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center text-pink-400 text-xs">🐶</div>
                            @endif
                            <span class="font-medium text-gray-700">{{ $booking->nama_pemilik }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-gray-600">{{ $booking->nama_hewan }} <span class="text-xs text-gray-400">({{ $booking->jenis_hewan }})</span></td>
                    <td class="px-4 py-3 text-gray-600">{{ $booking->jenis_layanan }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($booking->tanggal_reservasi)->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        @php
                            $statusColor = [
                                'pending'   => 'bg-yellow-100 text-yellow-700',
                                'confirmed' => 'bg-blue-100 text-blue-700',
                                'done'      => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ][$booking->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('booking.show', $booking) }}"
                               class="text-blue-500 hover:text-blue-700 text-xs font-medium">Detail</a>
                            <a href="{{ route('booking.edit', $booking) }}"
                               class="text-yellow-500 hover:text-yellow-700 text-xs font-medium">Edit</a>
                            <form action="{{ route('booking.destroy', $booking) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-500 hover:text-red-700 text-xs font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-10 text-center text-gray-400">
                        <div class="text-4xl mb-2">🐾</div>
                        Belum ada reservasi. <a href="{{ route('booking.create') }}" class="text-pink-500 underline">Buat sekarang!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
</div>

<script>
    function renderSearchRows(bookings) {
        return bookings.map(booking => {
            const statusClasses = {
                pending: 'bg-yellow-100 text-yellow-700',
                confirmed: 'bg-blue-100 text-blue-700',
                done: 'bg-green-100 text-green-700',
                cancelled: 'bg-red-100 text-red-700',
            };
            const statusClass = statusClasses[booking.status] || 'bg-gray-100 text-gray-700';
            return `
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-mono font-semibold text-pink-600">${booking.kode_booking}</td>
                    <td class="px-4 py-3 text-gray-700">${booking.nama_pemilik}</td>
                    <td class="px-4 py-3 text-gray-600">${booking.nama_hewan} <span class="text-xs text-gray-400">(${booking.jenis_hewan})</span></td>
                    <td class="px-4 py-3 text-gray-600">${booking.jenis_layanan}</td>
                    <td class="px-4 py-3 text-gray-600">${booking.tanggal_reservasi}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium ${statusClass}">
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
            resultsBody.innerHTML = '<tr><td colspan="6" class="px-4 py-4 text-gray-500">Memuat hasil...</td></tr>';

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

                if (!response.ok) {
                    throw new Error('Gagal memuat data hasil pencarian');
                }

                const json = await response.json();
                const bookings = json.data || [];

                if (bookings.length === 0) {
                    resultsBody.innerHTML = '<tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Tidak ada hasil pencarian untuk kata kunci ini.</td></tr>';
                    status.textContent = `Menampilkan hasil untuk "${query}". Tidak ditemukan.`;
                } else {
                    resultsBody.innerHTML = renderSearchRows(bookings);
                    status.textContent = `Menampilkan ${bookings.length} hasil untuk "${query}".`;
                }
            } catch (error) {
                resultsBody.innerHTML = '<tr><td colspan="6" class="px-4 py-8 text-center text-red-500">Terjadi kesalahan saat memuat hasil. Coba lagi.</td></tr>';
                status.textContent = 'Terjadi problem saat memuat pencarian.';
                console.error(error);
            }
        });
    });
</script>
@endsection