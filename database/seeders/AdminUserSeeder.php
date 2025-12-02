<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProgramEnrollment;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@trueform.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Ensure is_admin is set to true if user already exists
        if (!$admin->is_admin) {
            $admin->is_admin = true;
            $admin->save();
        }

        // Create program enrollment for admin (so they can access all features)
        UserProgramEnrollment::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'start_date' => Carbon::today(),
                'is_active' => true,
                'baseline_completed' => false,
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@trueform.com');
        $this->command->info('Password: password');
        $this->command->warn('⚠️  Please change the password after first login!');
    }
}
