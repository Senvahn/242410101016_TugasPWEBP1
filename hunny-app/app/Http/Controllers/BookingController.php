<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        // Admin lihat semua, customer hanya lihat punyanya sendiri
        if (auth()->user()->isAdmin()) {
            $bookings = Booking::latest()->paginate(10);
            return view('admin.reservasi', compact('bookings'));
        }

        $bookings = Booking::where('user_id', auth()->id())->latest()->paginate(10);
        return view('booking.index', compact('bookings'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->orderBy('price')->get();
        return view('booking.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemilik'     => 'required|min:3',
            'email'            => 'required|email|max:190',
            'service_id'       => 'required|exists:services,id',
            'pilihan_jam'      => ['required', 'string', 'regex:/^([01]\d|2[0-3]):00$/'],
            'nama_hewan'       => 'required|min:2',
            'jenis_hewan'      => 'required|in:Anjing,Kucing,Kelinci,Lainnya',
            'tanggal_reservasi'=> 'required|date|after_or_equal:today',
            'catatan'          => 'nullable|string|max:500',
            'pet_photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $service = Service::find($validated['service_id']);

        $validated['jenis_layanan'] = $service->name;
        $validated['kode_booking'] = 'HNY-' . strtoupper(Str::random(6));
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('pet_photo')) {
            $validated['pet_photo'] = $request->file('pet_photo')->store('pet_photos', 'public');
        }

        $booking = Booking::create(array_merge($validated, [
            'status' => 'pending',
        ]));

        return redirect()->route('booking.checkout', $booking)
            ->with('success', 'Reservasi berhasil dibuat! Silakan lanjutkan ke checkout.');
    }

    public function checkout(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('booking.checkout', compact('booking'));
    }

    public function processPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:E-Wallet,QRIS,Bayar di Toko',
            'payment_proof'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika QRIS atau E-Wallet, payment_proof wajib
        if (in_array($validated['payment_method'], ['QRIS', 'E-Wallet'])) {
            if (!$request->hasFile('payment_proof')) {
                return back()->withErrors(['payment_proof' => 'Bukti pembayaran wajib diunggah untuk metode ini.']);
            }
        }

        $updateData = [
            'payment_method' => $validated['payment_method'],
        ];

        if ($request->hasFile('payment_proof')) {
            // Hapus file lama jika ada
            if ($booking->payment_proof) {
                \Storage::disk('public')->delete($booking->payment_proof);
            }
            $updateData['payment_proof'] = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // Status tetap pending, admin yang akan mengkonfirmasi
        $booking->update($updateData);

        return redirect()->route('booking.show', $booking)
            ->with('success', 'Pembayaran berhasil disimpan. Pesanan Anda dalam status pending menunggu konfirmasi admin.');
            if ($booking->payment_proof) {
                \Storage::disk('public')->delete($booking->payment_proof);
            }
    }

    public function show(Booking $booking)
    {
        return view('booking.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $services = Service::where('is_active', true)->orderBy('price')->get();
        return view('booking.edit', compact('booking', 'services'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'nama_pemilik'     => 'required|min:3',
            'email'            => 'required|email|max:190',
            'service_id'       => 'required|exists:services,id',
            'pilihan_jam'      => ['required', 'string', 'regex:/^([01]\d|2[0-3]):00$/'],
            'nama_hewan'       => 'required|min:2',
            'jenis_hewan'      => 'required|in:Anjing,Kucing,Kelinci,Lainnya',
            'tanggal_reservasi'=> 'required|date',
            'status'           => 'required|in:pending,confirmed,done,cancelled',
            'catatan'          => 'nullable|string|max:500',
            'pet_photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $service = Service::find($validated['service_id']);
        $validated['jenis_layanan'] = $service->name;

        if ($request->hasFile('pet_photo')) {
            if ($booking->pet_photo) {
                \Storage::disk('public')->delete($booking->pet_photo);
            }
            $validated['pet_photo'] = $request->file('pet_photo')->store('pet_photos', 'public');
        }

        $booking->update($validated);

        return redirect()->route('booking.index')
            ->with('success', 'Reservasi berhasil diperbarui! ✅');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->pet_photo) {
            \Storage::disk('public')->delete($booking->pet_photo);
        }

        if ($booking->foto_hewan) {
            \Storage::disk('public')->delete($booking->foto_hewan);
        }

        $booking->delete();

        return redirect()->route('booking.index')
            ->with('success', 'Reservasi berhasil dihapus.');
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'nullable|string|max:255',
        ]);

        $query = trim($request->input('query', ''));

        $search = Booking::query();

        if (!auth()->user()->isAdmin()) {
            $search->where('user_id', auth()->id());
        }

        if ($query !== '') {
            $search->where(function ($builder) use ($query) {
                $builder->where('kode_booking', 'like', "%{$query}%")
                    ->orWhere('nama_pemilik', 'like', "%{$query}%")
                    ->orWhere('nama_hewan', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            });
        }

        $results = $search->latest()->limit(20)->get();

        return response()->json([
            'data' => $results->map(function ($booking) {
                return [
                    'kode_booking' => $booking->kode_booking,
                    'nama_pemilik' => $booking->nama_pemilik,
                    'nama_hewan' => $booking->nama_hewan,
                    'jenis_hewan' => $booking->jenis_hewan,
                    'jenis_layanan' => $booking->jenis_layanan,
                    'tanggal_reservasi' => $booking->tanggal_reservasi,
                    'status' => $booking->status,
                ];
            }),
        ]);
    }

    /**
     * Update booking status (admin only)
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,done',
        ]);

        $booking->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.reservasi')->with('success', 'Status reservasi berhasil diperbarui.');
    }
}