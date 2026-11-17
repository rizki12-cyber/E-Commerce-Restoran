<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Dapur Kaysan',
            'email' => 'admin@dapurkaysan.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Customer Demo',
            'email' => 'customer@dapurkaysan.test',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081298765432',
            'email_verified_at' => now(),
        ]);
    }
}