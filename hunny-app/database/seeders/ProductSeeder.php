<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $sup1 = Supplier::updateOrCreate(['nama_supplier' => 'PT. Makanan Hewan'], ['kontak' => '08111111111']);
        $sup2 = Supplier::updateOrCreate(['nama_supplier' => 'CV. Aksesoris Pet'], ['kontak' => '08222222222']);

        $items = [
            ['kode_barang' => 'FOOD-001','nama_barang' => 'Makanan Kucing ProPlan','kategori' => 'Makanan','jumlah' => 25,'satuan' => 'Kg','harga_beli'=>120000,'tanggal_masuk'=>now(),'supplier_id'=>$sup1->id],
            ['kode_barang' => 'SHAM-001','nama_barang' => 'Shampoo Anti Kutu','kategori' => 'Kesehatan','jumlah' => 40,'satuan' => 'Botol','harga_beli'=>35000,'tanggal_masuk'=>now(),'supplier_id'=>$sup1->id],
            ['kode_barang' => 'TOY-001','nama_barang' => 'Mainan Tikus Karet','kategori' => 'Aksesoris','jumlah' => 12,'satuan' => 'Pcs','harga_beli'=>15000,'tanggal_masuk'=>now(),'supplier_id'=>$sup2->id],
            ['kode_barang' => 'KAND-001','nama_barang' => 'Kandang Besi Size L','kategori' => 'Fasilitas','jumlah' => 6,'satuan' => 'Unit','harga_beli'=>500000,'tanggal_masuk'=>now(),'supplier_id'=>$sup2->id],
            ['kode_barang' => 'VIT-001','nama_barang' => 'Vitamin Bulu','kategori' => 'Kesehatan','jumlah' => 30,'satuan' => 'Box','harga_beli'=>45000,'tanggal_masuk'=>now(),'supplier_id'=>$sup1->id],
        ];

        foreach ($items as $it) {
            Produk::updateOrCreate(['kode_barang' => $it['kode_barang']], $it);
        }
    }
}
