<?php

namespace Database\Seeders;

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
        // Cek apakah admin sudah ada
        $admin = User::where('email', 'admin@ucb.com')->first();

        if (!$admin) {
            User::create([
                'name' => 'Admin UCB',
                'email' => 'admin@ucb.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Admin user created successfully!');
            $this->command->info('📧 Email: admin@ucb.com');
            $this->command->info('🔑 Password: admin123');
        } else {
            // Update password jika sudah ada
            $admin->update([
                'password' => Hash::make('admin123'),
            ]);
            
            $this->command->warn('⚠️  Admin user already exists! Password has been reset.');
            $this->command->info('📧 Email: admin@ucb.com');
            $this->command->info('🔑 Password: admin123');
        }
    }
}

