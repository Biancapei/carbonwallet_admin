<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update or create admin user
        User::updateOrCreate(
            ['email' => 'admin@carbonwallet.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('Password123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
