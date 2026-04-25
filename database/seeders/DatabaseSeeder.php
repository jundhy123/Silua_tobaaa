<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Masukkan data admin Anda di sini agar tidak hilang lagi saat migrate:fresh
        User::create([
            'customer_id' => 'ADM-001',
            'name'        => 'Super Admin Silua',
            'first_name'  => 'Super',
            'last_name'   => 'Admin',
            'email'       => 'admin@silua.com', // Ganti sesuai keinginan
            'password'    => Hash::make('admin123'), // Ganti sesuai keinginan
            'role'        => 'admin',
        ]);
    }
}