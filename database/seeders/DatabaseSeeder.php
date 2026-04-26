<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SuperAdminSeeder::class,
            PricingPlanSeeder::class,
            SchoolSeeder::class,
            AdminSeeder::class,
            DemoSeeder::class,
            LandingPageSeeder::class,
            PaymentSettingSeeder::class,
            LandingSettingSeeder::class,
        ]);
    }
}