<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\AdmissionBatch;
use App\Models\School;
use App\Models\PricingPlan;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proPlan = PricingPlan::where('name', 'Pro Starter')->first();
        $freePlan = PricingPlan::where('name', 'Free Basic')->first();

        // 1. Create School 1 (Pro)
        $school1 = School::updateOrCreate(
            ['slug' => 'sma-ppdb-pro'],
            [
                'name' => 'SMA PPDB Pro',
                'education_level_code' => 'SMA',
                'education_level_name' => 'Sekolah Menengah Atas',
                'is_custom_level' => false,
                'npsn' => '12345678',
                'email' => 'info@sma-ppdb-pro.sch.id',
                'phone' => '021-123456',
                'address' => 'Jl. Pendidikan No. 1, Jakarta',
                'is_registration_open' => true,
                'pricing_plan_id' => $proPlan->id ?? null,
                'trial_ends_at' => null, // Permanent Access via Plan
            ]
        );

        // Create Academic Year for School 1
        $year1 = AcademicYear::updateOrCreate(
            ['school_id' => $school1->id, 'name' => '2024/2025'],
            ['start_date' => '2024-07-01', 'end_date' => '2025-06-30', 'is_active' => true]
        );

        // Create Admission Batch for School 1
        AdmissionBatch::updateOrCreate(
            ['school_id' => $school1->id, 'academic_year_id' => $year1->id, 'name' => 'Gelombang 1'],
            ['start_date' => '2024-01-01', 'end_date' => '2024-05-31', 'is_active' => true]
        );

        // 2. Create School 2 (Free)
        $school2 = School::updateOrCreate(
            ['slug' => 'smp-gratis'],
            [
                'name' => 'SMP Gratis Terbatas',
                'education_level_code' => 'SMP',
                'education_level_name' => 'Sekolah Menengah Pertama',
                'is_custom_level' => false,
                'npsn' => '87654321',
                'email' => 'info@smp-gratis.sch.id',
                'phone' => '021-654321',
                'address' => 'Jl. Bebas No. 2, Bandung',
                'is_registration_open' => true,
                'pricing_plan_id' => $freePlan->id ?? null,
                'trial_ends_at' => now()->subDays(1), // Trial expired to demonstrate limits
            ]
        );

        // Create Academic Year for School 2
        $year2 = AcademicYear::updateOrCreate(
            ['school_id' => $school2->id, 'name' => '2024/2025'],
            ['start_date' => '2024-07-01', 'end_date' => '2025-06-30', 'is_active' => true]
        );

        // Create Admission Batch for School 2
        AdmissionBatch::updateOrCreate(
            ['school_id' => $school2->id, 'academic_year_id' => $year2->id, 'name' => 'Gelombang Pendaftaran'],
            ['start_date' => '2024-01-01', 'end_date' => '2024-05-31', 'is_active' => true]
        );

        $this->command->info('School configuration seeded successfully.');
    }
}