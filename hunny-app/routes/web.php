<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PreferenceController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'beranda')->name('beranda');
Route::view('/customer', 'customer')->name('customer');
Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('services.index');
Route::get('/shop', function(){
    $produks = App\Models\Produk::where('status_tersedia', true)->get();
    return view('shop.index', compact('produks'));
})->name('shop.index');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');
Route::get('/orders/search', [OrderController::class, 'search'])->name('orders.search');
Route::get('/pesanan-saya', [OrderController::class, 'historyPage'])->name('pesanan.saya');
Route::view('/kontak', 'kontak')->name('kontak');
Route::redirect('/pembayaran', '/checkout');
Route::view('/tentang', 'tentang')->name('tentang');
Route::get('/preferensi', [PreferenceController::class, 'index'])->name('preferensi.index');
Route::post('/preferensi', [PreferenceController::class, 'store'])->name('preferensi.store');
Route::post('/preferensi/reset', [PreferenceController::class, 'reset'])->name('preferensi.reset');

Route::get('/dashboard', function () {
    return redirect()->route('beranda');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Customer: hanya bisa lihat & buat booking miliknya
    Route::post('/booking/search', [BookingController::class, 'search'])->name('booking.search');

    Route::resource('booking', BookingController::class)
         ->only(['index', 'create', 'store', 'show']);

    // Admin only: bisa edit, update, hapus
    Route::resource('booking', BookingController::class)
         ->only(['edit', 'update', 'destroy'])
         ->middleware('cek.admin');

    Route::middleware('cek.admin')->group(function () {
        Route::get('/admin/stok', [\App\Http\Controllers\AdminProdukController::class, 'index'])->name('admin.stok');
        Route::get('/admin/input', [\App\Http\Controllers\AdminProdukController::class, 'create'])->name('admin.input');
        Route::post('/admin/produk', [\App\Http\Controllers\AdminProdukController::class, 'store'])->name('admin.produk.store');
        Route::delete('/admin/produk/{produk}', [\App\Http\Controllers\AdminProdukController::class, 'destroy'])->name('admin.produk.destroy');

        Route::get('/admin/konfirmasi', [OrderController::class, 'adminIndex'])->name('admin.konfirmasi');
        Route::post('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
        Route::get('/admin/reservasi', [BookingController::class, 'index'])->name('admin.reservasi');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
