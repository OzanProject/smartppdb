<?php

namespace Database\Seeders;

use App\Models\AdmissionBatch;
use App\Models\School;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::first();
        $batch = AdmissionBatch::first();

        if (!$school || !$batch) {
            $this->command->error('No school or batch found. Run SchoolSeeder first.');
            return;
        }

        // Demo Applicant
        $applicant = User::updateOrCreate(
            ['email' => 'budi@mail.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'applicant',
                'email_verified_at' => now(),
            ]
        );

        // Demo Registration
        Registration::updateOrCreate(
            [
                'user_id' => $applicant->id,
                'admission_batch_id' => $batch->id,
            ],
            [
                'school_id' => $school->id,
                'registration_number' => 'REG-' . strtoupper(Str::random(8)),
                'status' => 'pending',
                'personal_data' => [
                    'full_name' => 'Budi Santoso',
                    'gender' => 'Laki-laki',
                    'place_of_birth' => 'Jakarta',
                    'date_of_birth' => '2010-05-15',
                    'nik' => '3201234567890001',
                ],
                'parent_data' => [
                    'father_name' => 'Slamet',
                    'mother_name' => 'Siti',
                ],
                'created_at' => now()->subDays(2),
            ]
        );

        $this->command->info('Demo data seeded successfully.');
    }
}
