<?php

namespace Database\Seeders;

use App\Models\PricingPlan;
use Illuminate\Database\Seeder;

class PricingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free Basic',
                'price_display' => 'Gratis',
                'description' => 'Selamanya gratis, akses terbatas',
                'features' => "Manajemen Data Pendaftar\nSeleksi Siswa Diterima\nMax 10 Pendaftar/tahun\nSupport Komunitas",
                'is_popular' => false,
                'order_weight' => 1,
                'cta_text' => 'Daftar Gratis',
                'cta_link' => '#register',
                'allowed_modules' => ['pendaftaran'],
                'max_quota' => 10,
            ],
            [
                'name' => 'Pro Starter',
                'price_display' => 'Rp 299.000',
                'description' => 'Cocok untuk sekolah ukuran menengah',
                'features' => "Semua fitur Free\nManajemen Data Master (Tahun Ajaran, Gelombang)\nMax 500 Pendaftar\nEmail Support",
                'is_popular' => true,
                'order_weight' => 2,
                'cta_text' => 'Berlangganan Pro',
                'cta_link' => '#register',
                'allowed_modules' => ['master_data', 'pendaftaran'],
                'max_quota' => 500,
            ],
            [
                'name' => 'Enterprise',
                'price_display' => 'Rp 799.000',
                'description' => 'Solusi lengkap sekolah unggulan',
                'features' => "Pendaftar Tidak Terbatas\nForm Builder Kustom\nLanding Page Builder\nManajemen Pengguna\nSupport Prioritas 24/7",
                'is_popular' => false,
                'order_weight' => 3,
                'cta_text' => 'Hubungi Sales',
                'cta_link' => 'https://wa.me/628123456789',
                'allowed_modules' => ['master_data', 'pendaftaran', 'pengaturan'],
                'max_quota' => -1,
            ],
        ];

        foreach ($plans as $plan) {
            PricingPlan::updateOrCreate(['name' => $plan['name']], $plan);
        }
    }
}
