<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@projecthub.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Supervisors
        User::create([
            'name' => 'Dr. Ahmed',
            'email' => 'ahmed@projecthub.com',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Dr. Sara',
            'email' => 'sara@projecthub.com',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Dr. Omar',
            'email' => 'omar@projecthub.com',
            'password' => Hash::make('password'),
            'role' => 'supervisor',
            'is_active' => true,
        ]);
    }
}
