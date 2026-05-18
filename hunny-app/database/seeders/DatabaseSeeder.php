<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User untuk login
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 2. Jalankan StokSeeder, ProductSeeder dan ServiceSeeder untuk mengisi tabel produks, suppliers, dan services
        $this->call([
            StokSeeder::class,
            ProductSeeder::class,
            ServiceSeeder::class,
            AdminSeeder::class,
        ]);

        // 3. Buat Customer dummy
        $customer = Customer::create([
            'nama_customer' => 'Pelanggan Hunny Pet Care',
            'telepon' => '08123456789'
        ]);

        // 4. Ambil produk pertama hasil dari StokSeeder
        $produk = Produk::first();

        // 5. Hubungkan Customer ke Produk di tabel pivot customer_produk
        if ($produk) {
            $customer->produks()->attach($produk->id);
        }
    }
}