<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Basic Grooming',
                'description' => 'Mandi, pengeringan, dan penyisiran singkat untuk menjaga kebersihan hewan.',
                'price' => 75000,
                'duration_minutes' => 45,
                'is_active' => true,
            ],
            [
                'name' => 'Full Grooming',
                'description' => 'Paket lengkap: mandi, trimming, potong kuku, pembersihan telinga, dan styling.',
                'price' => 150000,
                'duration_minutes' => 90,
                'is_active' => true,
            ],
            [
                'name' => 'Spa & Treatment',
                'description' => 'Perawatan premium dengan masker, perawatan kulit, dan terapi aroma untuk kenyamanan hewan.',
                'price' => 250000,
                'duration_minutes' => 120,
                'is_active' => true,
            ],
            [
                'name' => 'Nail Trimming',
                'description' => 'Potong kuku profesional termasuk pemeriksaan kesehatan kaki.',
                'price' => 30000,
                'duration_minutes' => 20,
                'is_active' => true,
            ],
        ];

        foreach ($services as $s) {
            Service::updateOrCreate(['name' => $s['name']], $s);
        }
    }
}
