<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
    // Admin lihat semua, customer hanya lihat punyanya sendiri
    if (auth()->user()->isAdmin()) {
        $bookings = Booking::latest()->paginate(10);
    } else {
        $bookings = Booking::where('user_id', auth()->id())->latest()->paginate(10);
    }

    return view('booking.index', compact('bookings'));
    }

    public function create()
    {
        return view('booking.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemilik'     => 'required|min:3',
            'email'            => 'required|email|unique:bookings,email',
            'jenis_layanan'    => 'required|in:Basic Grooming,Full Grooming,Spa & Treatment,Nail Trimming',
            'nama_hewan'       => 'required|min:2',
            'jenis_hewan'      => 'required|in:Anjing,Kucing,Kelinci,Lainnya',
            'tanggal_reservasi'=> 'required|date|after_or_equal:today',
            'catatan'          => 'nullable|string|max:500',
            'foto_hewan'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Auto-generate kode booking
        $validated['kode_booking'] = 'HNY-' . strtoupper(Str::random(6));

        // Upload foto hewan
        if ($request->hasFile('foto_hewan')) {
            $validated['foto_hewan'] = $request->file('foto_hewan')->store('foto_hewan', 'public');
        }

        Booking::create($validated);

        return redirect()->route('booking.index')
            ->with('success', 'Reservasi berhasil dibuat! 🐾');
    }

    public function show(Booking $booking)
    {
        return view('booking.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        return view('booking.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'nama_pemilik'     => 'required|min:3',
            'email'            => 'required|email|unique:bookings,email,' . $booking->id,
            'jenis_layanan'    => 'required|in:Basic Grooming,Full Grooming,Spa & Treatment,Nail Trimming',
            'nama_hewan'       => 'required|min:2',
            'jenis_hewan'      => 'required|in:Anjing,Kucing,Kelinci,Lainnya',
            'tanggal_reservasi'=> 'required|date',
            'status'           => 'required|in:pending,confirmed,done,cancelled',
            'catatan'          => 'nullable|string|max:500',
            'foto_hewan'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload foto baru kalau ada
        if ($request->hasFile('foto_hewan')) {
            // Hapus foto lama kalau ada
            if ($booking->foto_hewan) {
                \Storage::disk('public')->delete($booking->foto_hewan);
            }
            $validated['foto_hewan'] = $request->file('foto_hewan')->store('foto_hewan', 'public');
        }

        $booking->update($validated);

        return redirect()->route('booking.index')
            ->with('success', 'Reservasi berhasil diperbarui! ✅');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->foto_hewan) {
            \Storage::disk('public')->delete($booking->foto_hewan);
        }

        $booking->delete();

        return redirect()->route('booking.index')
            ->with('success', 'Reservasi berhasil dihapus.');
    }
}