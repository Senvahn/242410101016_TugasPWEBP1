<?php

use Illuminate\Support\Facades\Route;

// --- FRONTEND / CUSTOMER ---
Route::get('/', function () { return view('beranda'); });
Route::get('/customer', function () { return view('customer'); });
Route::get('/pembayaran', function () { return view('pembayaran'); });
Route::get('/pesanan-saya', function () { return view('pesanan-saya'); });

// --- BACKEND / ADMIN ---
Route::get('/admin/input', function () { return view('admin.input'); });
Route::get('/admin/konfirmasi', function () { return view('admin.konfirmasi'); });
Route::get('/admin/stok', function () { return view('admin.stok'); });
Route::get('/admin/reservasi', function () { return view('admin.reservasi'); });