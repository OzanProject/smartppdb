<?php

namespace Database\Seeders;

use App\Models\LandingContent;
use App\Models\School;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::first();
        
        if (!$school) return;

        // 1. Update Hero & Stats
        $school->update([
            'hero_title' => 'Membangun Generasi Cerdas & Berkarakter di Era Digital',
            'hero_description' => 'Kami berkomitmen menyelenggarakan pendidikan berkualitas tinggi yang mengintegrasikan nilai moral dengan penguasaan teknologi mutakhir untuk menyiapkan masa depan gemilang bagi setiap siswa.',
            'stats_acc_label' => 'Akreditasi',
            'stats_acc_value' => 'A (Unggul)',
            'stats_count_label' => 'Siswa & Alumni',
            'stats_count_value' => '2.500+',
            'stats_grad_label' => 'Kelulusan',
            'stats_grad_value' => '100%',
        ]);

        // Clear existing contents to avoid duplicates during seeding
        LandingContent::where('school_id', $school->id)->delete();

        // 2. Add Featured Programs
        $programs = [
            [
                'type' => 'program',
                'title' => 'Kurikulum Merdeka IT',
                'content' => 'Implementasi kurikulum berbasis proyek dengan penguasaaan coding, robotika, dan literasi digital sejak dini.',
                'order_weight' => 1
            ],
            [
                'type' => 'program',
                'title' => 'Excellent Facilities',
                'content' => 'Lab Multimedia, Perpustakaan Digital, dan Ruang Kelas Smart-Learning untuk mendukung proses belajar mengajar yang interaktif.',
                'order_weight' => 2
            ],
            [
                'type' => 'program',
                'title' => 'Tahfidz & Karakter',
                'content' => 'Program pembinaan spiritual dan hafalan Al-Qur\'an untuk membentuk pribadi yang berakhlak mulia dan disiplin.',
                'order_weight' => 3
            ],
        ];

        foreach ($programs as $prog) {
            LandingContent::create(array_merge($prog, ['school_id' => $school->id, 'is_active' => true]));
        }

        // 3. Add Testimonials
        $testimonials = [
            [
                'type' => 'testimonial',
                'title' => 'Dian Kusuma, S.T.',
                'subtitle' => 'Alumni 2018 - Software Engineer @ Google',
                'content' => 'Dasar logika dan disiplin yang saya pelajari di sekolah ini menjadi fondasi kuat bagi karir saya di industri teknologi global.',
                'order_weight' => 1
            ],
            [
                'type' => 'testimonial',
                'title' => 'Dr. Ahmad Fauzi',
                'subtitle' => 'Alumni 2010 - Dokter Spesialis Bedah',
                'content' => 'Bukan hanya akademik, sekolah ini mengajarkan saya arti integritas dan pengabdian yang sangat berguna di dunia medis.',
                'order_weight' => 2
            ],
            [
                'type' => 'testimonial',
                'title' => 'Siti Aminah',
                'subtitle' => 'Mahasiswa @ UI - Penerima Beasiswa',
                'content' => 'Bimbingan intensif dari guru-guru membantu saya menembus universitas impian dengan jalur prestasi.',
                'order_weight' => 3
            ],
        ];

        foreach ($testimonials as $testi) {
            LandingContent::create(array_merge($testi, ['school_id' => $school->id, 'is_active' => true]));
        }

        // 4. Add FAQs
        $faqs = [
            [
                'type' => 'faq',
                'title' => 'Kapan pendaftaran siswa baru dibuka?',
                'content' => 'Pendaftaran Gelombang 1 biasanya dibuka pada bulan Januari hingga Maret setiap tahunnya.',
                'order_weight' => 1
            ],
            [
                'type' => 'faq',
                'title' => 'Apa saja syarat dokumen yang diperlukan?',
                'content' => 'Syarat utama meliputi Scan Kartu Keluarga, Akte Kelahiran, Ijazah/Raport terakhir, dan Pas Foto berwarna.',
                'order_weight' => 2
            ],
            [
                'type' => 'faq',
                'title' => 'Apakah tersedia beasiswa bagi siswa kurang mampu?',
                'content' => 'Ya, kami menyediakan jalur beasiswa Prestasi dan jalur KIP untuk membantu biaya pendidikan siswa berbakat.',
                'order_weight' => 3
            ],
            [
                'type' => 'faq',
                'title' => 'Apakah proses pendaftaran bisa dilakukan secara online?',
                'content' => 'Tentu, seluruh proses mulai dari pengisian formulir hingga unggah dokumen dapat dilakukan melalui portal ini.',
                'order_weight' => 4
            ],
            [
                'type' => 'faq',
                'title' => 'Bagaimana sistem seleksi yang diterapkan?',
                'content' => 'Seleksi dilakukan berdasarkan nilai raport, tes potensi akademik dasar, dan wawancara dengan calon siswa.',
                'order_weight' => 5
            ],
        ];

        foreach ($faqs as $faq) {
            LandingContent::create(array_merge($faq, ['school_id' => $school->id, 'is_active' => true]));
        }
    }
}
