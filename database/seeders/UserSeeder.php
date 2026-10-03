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
        // Create a default admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // Check for existing admin user by email
            [
                'name' => 'Default Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // Default password
                'usertype' => 'admin',
                'mobile' => '9876501234'
            ]
        );
    }
}
