<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = School::take(2)->get();

        if ($schools->isEmpty()) {
            $this->command->error('No school found. Run SchoolSeeder first.');
            return;
        }

        // School 1 (Pro) Admin
        if (isset($schools[0])) {
            User::updateOrCreate(
                ['email' => 'admin@gmail.com'],
                [
                    'name' => 'Admin PPDB Pro',
                    'password' => Hash::make('password'),
                    'role' => 'admin_school',
                    'school_id' => $schools[0]->id,
                    'email_verified_at' => now(),
                ]
            );
        }

        // School 2 (Free) Admin
        if (isset($schools[1])) {
            User::updateOrCreate(
                ['email' => 'admin2@mail.com'],
                [
                    'name' => 'Admin Gratis',
                    'password' => Hash::make('password'),
                    'role' => 'admin_school',
                    'school_id' => $schools[1]->id,
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('Admin accounts seeded successfully.');
    }
}
