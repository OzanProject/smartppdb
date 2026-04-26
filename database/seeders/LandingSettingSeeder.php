<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingSetting;

class LandingSettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // GENERAL & BRANDING
            ['group' => 'Branding', 'key' => 'app_name', 'value' => 'PPDB PRO'],
            ['group' => 'Branding', 'key' => 'app_slogan', 'value' => 'Platform PPDB Digital Terpadu'],
            ['group' => 'Branding', 'key' => 'app_logo', 'value' => ''],
            ['group' => 'Branding', 'key' => 'app_favicon', 'value' => ''],
            ['group' => 'Branding', 'key' => 'footer_text', 'value' => '© 2026 PPDB PRO. All rights reserved.'],

            // CONTACT INFO
            ['group' => 'Contact', 'key' => 'app_email', 'value' => 'info@ppdb-pro.com'],
            ['group' => 'Contact', 'key' => 'app_phone', 'value' => '021-12345678'],
            ['group' => 'Contact', 'key' => 'app_address', 'value' => 'Jl. Pendidikan No. 123, Jakarta Selatan, Indonesia'],
            
            // SOSMED (SOCIAL MEDIA)
            ['group' => 'Sosmed', 'key' => 'app_facebook', 'value' => 'https://facebook.com/ppdbpro'],
            ['group' => 'Sosmed', 'key' => 'app_instagram', 'value' => 'https://instagram.com/ppdbpro'],
            ['group' => 'Sosmed', 'key' => 'app_youtube', 'value' => 'https://youtube.com/ppdbpro'],
            ['group' => 'Sosmed', 'key' => 'app_x', 'value' => 'https://x.com/ppdbpro'],
            ['group' => 'Sosmed', 'key' => 'app_tiktok', 'value' => 'https://tiktok.com/@ppdbpro'],
            ['group' => 'Sosmed', 'key' => 'app_linkedin', 'value' => 'https://linkedin.com/company/ppdbpro'],

            // FAQ SECTION
            ['group' => 'FAQ', 'key' => 'faq_title', 'value' => 'Pertanyaan Umum'],
            ['group' => 'FAQ', 'key' => 'faq_subtitle', 'value' => 'Temukan jawaban cepat untuk pertanyaan yang sering diajukan seputar layanan kami.'],
            
            // FOOTER SETTINGS
            ['group' => 'Footer', 'key' => 'footer_solusi_title', 'value' => 'Solusi'],
            ['group' => 'Footer', 'key' => 'footer_perusahaan_title', 'value' => 'Perusahaan'],
            ['group' => 'Footer', 'key' => 'footer_text', 'value' => '© 2026 PPDB PRO Platform. All rights reserved.'],

            // HERO SECTION
            ['group' => 'Hero', 'key' => 'hero_badge', 'value' => 'Solusi PPDB Sekolah Modern'],
            ['group' => 'Hero', 'key' => 'hero_title', 'value' => 'Masih Ribet Urus PPDB Manual?'],
            ['group' => 'Hero', 'key' => 'hero_description', 'value' => 'Form kertas hilang, data berantakan, atau orang tua bingung daftar? Saatnya upgrade ke sistem PPDB online yang rapi, cepat, dan profesional.'],
            ['group' => 'Hero', 'key' => 'hero_cta', 'value' => '🚀 Mulai Digital Sekarang'],
            ['group' => 'Hero', 'key' => 'hero_video_url', 'value' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'],
            
            // PRICING
            ['group' => 'Pricing', 'key' => 'pricing_title', 'value' => 'Investasi Terbaik'],
            ['group' => 'Pricing', 'key' => 'pricing_subtitle', 'value' => 'Pilih paket yang paling sesuai dengan kapasitas sekolah Anda.'],
            ['group' => 'Pricing', 'key' => 'price_starter_label', 'value' => 'Starter'],
            ['group' => 'Pricing', 'key' => 'price_starter_val', 'value' => '299rb'],
            ['group' => 'Pricing', 'key' => 'price_pro_label', 'value' => 'Professional'],
            ['group' => 'Pricing', 'key' => 'price_pro_val', 'value' => '799rb'],
            
            // PROBLEM SECTION
            ['group' => 'Problem', 'key' => 'problem_title', 'value' => 'Masalah yang Sering Terjadi'],
            ['group' => 'Problem', 'key' => 'problem_subtitle', 'value' => 'PPDB manual hanya akan menghambat pertumbuhan institusi Anda.'],
            ['group' => 'Problem', 'key' => 'problem_1_title', 'value' => 'Data Tercecer'],
            ['group' => 'Problem', 'key' => 'problem_1_desc', 'value' => 'Formulir kertas menumpuk, rawan hilang, dan sulit dicari saat dibutuhkan mendesak.'],
            ['group' => 'Problem', 'key' => 'problem_2_title', 'value' => 'Pendaftaran Sulit'],
            ['group' => 'Problem', 'key' => 'problem_2_desc', 'value' => 'Orang tua harus datang ke sekolah berkali-kali hanya untuk urusan administrasi dasar.'],
            ['group' => 'Problem', 'key' => 'problem_3_title', 'value' => 'Rawan Kesalahan'],
            ['group' => 'Problem', 'key' => 'problem_3_desc', 'value' => 'Input data manual berisiko tinggi salah ketik dan duplikasi data yang membingungkan.'],

            // FEATURE SECTION
            ['group' => 'Feature', 'key' => 'features_title', 'value' => 'Solusi Lengkap dalam 1 Sistem'],
            ['group' => 'Feature', 'key' => 'features_subtitle', 'value' => 'Kami menghadirkan fitur-fitur tercanggih untuk memastikan PPDB sekolah Anda berjalan tanpa hambatan.'],
            ['group' => 'Feature', 'key' => 'feature_1_title', 'value' => 'Pendaftaran Online'],
            ['group' => 'Feature', 'key' => 'feature_1_desc', 'value' => 'Siswa dapat mendaftar dari mana saja dan kapan saja. Dilengkapi dengan upload dokumen otomatis yang aman.'],
            ['group' => 'Feature', 'key' => 'feature_2_title', 'value' => 'Dashboard Admin'],
            ['group' => 'Feature', 'key' => 'feature_2_desc', 'value' => 'Kelola pendaftar, verifikasi berkas, hingga publikasi hasil seleksi dalam satu tampilan yang intuitif.'],
            ['group' => 'Feature', 'key' => 'feature_3_title', 'value' => 'Laporan Otomatis'],
            ['group' => 'Feature', 'key' => 'feature_3_desc', 'value' => 'Dapatkan laporan statistik pendaftaran dan data siswa yang siap cetak (PDF/Excel) kapan saja dibutuhkan.'],

            // TESTIMONIAL SECTION
            ['group' => 'Testimonial', 'key' => 'testimonial_title', 'value' => 'Apa Kata Mereka?'],
            ['group' => 'Testimonial', 'key' => 'testimonial_quote', 'value' => 'Sejak kami beralih ke PPDB Pro, proses pendaftaran siswa baru menjadi jauh lebih cepat, rapi, dan terukur. Orang tua siswa juga sangat terbantu karena bisa mendaftar dari rumah.'],
            ['group' => 'Testimonial', 'key' => 'testimonial_author', 'value' => 'Haji Syarifuddin'],
            ['group' => 'Testimonial', 'key' => 'testimonial_role', 'value' => 'Kepala Sekolah, Islamic School Jakarta'],

            // SEO SECTION
            ['group' => 'SEO', 'key' => 'seo_description', 'value' => 'Sistem Informasi PPDB Online SaaS terbaik untuk manajemen pendaftaran siswa baru yang efisien dan profesional.'],
            ['group' => 'SEO', 'key' => 'seo_keywords', 'value' => 'ppdb online, saas ppdb, aplikasi pendaftaran sekolah, sistem informasi sekolah'],
            ['group' => 'SEO', 'key' => 'seo_meta_description', 'value' => 'Sistem Informasi PPDB Online SaaS terbaik untuk manajemen pendaftaran siswa baru.'],
            ['group' => 'SEO', 'key' => 'seo_meta_keywords', 'value' => 'ppdb online, saas ppdb, aplikasi pendaftaran sekolah'],
            ['group' => 'SEO', 'key' => 'seo_og_title', 'value' => 'PPDB PRO - Solusi PPDB Digital'],
            ['group' => 'SEO', 'key' => 'seo_og_description', 'value' => 'Kelola pendaftaran siswa baru lebih mudah, cepat, dan profesional.'],
            ['group' => 'SEO', 'key' => 'seo_og_image', 'value' => ''],
        ];

        foreach ($settings as $setting) {
            LandingSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
