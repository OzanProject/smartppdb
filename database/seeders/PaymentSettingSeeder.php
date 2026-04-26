<?php

namespace Database\Seeders;

use App\Models\PaymentSetting;
use Illuminate\Database\Seeder;

class PaymentSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'bank_name' => 'BCA (Bank Central Asia)',
            'bank_account_number' => '1234567890',
            'bank_account_name' => 'PT PPDB Pro Indonesia',
            'payment_instructions' => "1. Transfer sesuai nominal yang tertera di invoice.\n2. Pastikan transfer dari rekening atas nama sekolah.\n3. Screenshot bukti transfer dan unggah pada halaman invoice.\n4. Konfirmasi akan diproses dalam 1x24 jam kerja.",
            'enable_gateway' => '0',
        ];

        foreach ($settings as $key => $value) {
            PaymentSetting::setValue($key, $value);
        }
    }
}
