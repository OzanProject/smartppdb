<?php

use App\Models\LandingSetting;

$faqSettings = [
    ['group' => 'FAQ', 'key' => 'faq_title', 'value' => 'Pertanyaan Umum'],
    ['group' => 'FAQ', 'key' => 'faq_subtitle', 'value' => 'Masih punya pertanyaan? Kami siap membantu menjawab keraguan Anda.'],
    ['group' => 'FAQ', 'key' => 'faq_1_q', 'value' => 'Apakah sekolah saya bisa mencoba gratis?'],
    ['group' => 'FAQ', 'key' => 'faq_1_a', 'value' => 'Tentu saja! Kami memberikan masa trial selama 14 hari dengan fitur lengkap agar Anda bisa mencoba sistem kami tanpa risiko.'],
    ['group' => 'FAQ', 'key' => 'faq_2_q', 'value' => 'Bagaimana jika saya butuh bantuan teknis?'],
    ['group' => 'FAQ', 'key' => 'faq_2_a', 'value' => 'Kami menyediakan dukungan teknis melalui WhatsApp dan Email selama jam kerja untuk membantu proses setup dan kendala operasional.'],
    ['group' => 'FAQ', 'key' => 'faq_3_q', 'value' => 'Apakah data calon siswa aman?'],
    ['group' => 'FAQ', 'key' => 'faq_3_a', 'value' => 'Sangat aman. Kami menggunakan enkripsi tingkat tinggi dan server yang andal untuk memastikan data sekolah dan calon siswa tidak bocor.'],
    ['group' => 'FAQ', 'key' => 'faq_4_q', 'value' => 'Bisakah saya upgrade atau downgrade paket?'],
    ['group' => 'FAQ', 'key' => 'faq_4_a', 'value' => 'Bisa. Anda dapat mengubah paket langganan kapan saja sesuai dengan kebutuhan jumlah pendaftar di sekolah Anda.'],
];

foreach ($faqSettings as $setting) {
    LandingSetting::updateOrCreate(
        ['key' => $setting['key']],
        $setting
    );
}

echo "FAQ settings initialized successfully!";
