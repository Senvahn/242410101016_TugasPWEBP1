<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// --- FRONTEND / CUSTOMER ---
Route::get('/', function () { return view('beranda'); });
Route::get('/customer', function () { return view('customer'); });
Route::get('/pembayaran', function () { return view('pembayaran'); });
Route::get('/pesanan-saya', function () { return view('pesanan-saya'); });

// --- HALAMAN UTAMA LAYOUT MASTER ---
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/tentang',   [DashboardController::class, 'tentang'])->name('tentang');
Route::get('/kontak',    [DashboardController::class, 'kontak'])->name('kontak');
Route::post('/kontak',   [DashboardController::class, 'kirimKontak'])->name('kontak.kirim');

// --- BACKEND / ADMIN ---
Route::get('/admin/input',      function () { return view('admin.input'); });
Route::get('/admin/konfirmasi', function () { return view('admin.konfirmasi'); });
Route::get('/admin/stok',       function () { return view('admin.stok'); });
Route::get('/admin/reservasi',  function () { return view('admin.reservasi'); });