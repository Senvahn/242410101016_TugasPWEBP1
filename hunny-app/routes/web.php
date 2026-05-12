<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'beranda')->name('beranda');
Route::view('/customer', 'customer')->name('customer');
Route::view('/kontak', 'kontak')->name('kontak');
Route::view('/pembayaran', 'pembayaran')->name('pembayaran');
Route::view('/pesanan-saya', 'pesanan-saya')->name('pesanan.saya');
Route::view('/tentang', 'tentang')->name('tentang');

Route::get('/dashboard', function () {
    return redirect()->route('beranda');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Customer: hanya bisa lihat & buat booking miliknya
    Route::resource('booking', BookingController::class)
         ->only(['index', 'create', 'store', 'show']);

    // Admin only: bisa edit, update, hapus
    Route::resource('booking', BookingController::class)
         ->only(['edit', 'update', 'destroy'])
         ->middleware('cek.admin');

    Route::view('/admin/input', 'admin.input')->name('admin.input');
    Route::view('/admin/konfirmasi', 'admin.konfirmasi')->name('admin.konfirmasi');
    Route::view('/admin/reservasi', 'admin.reservasi')->name('admin.reservasi');
    Route::view('/admin/stok', 'admin.stok')->name('admin.stok');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
