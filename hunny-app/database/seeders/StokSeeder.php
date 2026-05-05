<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
public function run(): void
    {
    // Ganti 'stoks' menjadi 'produks' agar sesuai dengan hasil migrasi kamu
    \Illuminate\Support\Facades\DB::table('produks')->insert([
        ['nama_barang' => 'Makanan Kucing ProPlan', 'kategori' => 'Makanan', 'jumlah' => 15, 'satuan' => 'Kg', 'status_tersedia' => true, 'tanggal_masuk' => now()],
        ['nama_barang' => 'Shampoo Anti Kutu', 'kategori' => 'Perawatan', 'jumlah' => 20, 'satuan' => 'Botol', 'status_tersedia' => true, 'tanggal_masuk' => now()],
        ['nama_barang' => 'Pasir Kucing Wangi', 'kategori' => 'Kebersihan', 'jumlah' => 50, 'satuan' => 'Pcs', 'status_tersedia' => true, 'tanggal_masuk' => now()],
        ['nama_barang' => 'Mainan Tikus Karet', 'kategori' => 'Aksesoris', 'jumlah' => 10, 'satuan' => 'Pcs', 'status_tersedia' => true, 'tanggal_masuk' => now()],
        ['nama_barang' => 'Kandang Besi Size L', 'kategori' => 'Fasilitas', 'jumlah' => 5, 'satuan' => 'Unit', 'status_tersedia' => true, 'tanggal_masuk' => now()],
        ['nama_barang' => 'Vitamin Bulu', 'kategori' => 'Kesehatan', 'jumlah' => 30, 'satuan' => 'Box', 'status_tersedia' => true, 'tanggal_masuk' => now()],
    ]);
    }
}