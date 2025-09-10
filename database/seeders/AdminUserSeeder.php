<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        if (!User::where('email', 'admin@portfolio.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@portfolio.com',
                'password' => Hash::make('admin123'),
            ]);
            
            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@portfolio.com');
            $this->command->info('Password: admin123');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
