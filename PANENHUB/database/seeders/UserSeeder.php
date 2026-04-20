<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // <-- BARIS INI WAJIB ADA
use Illuminate\Support\Facades\Hash; // <-- BARIS INI JUGA WAJIB UNTUK PASSWORD

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Testing untuk Mitra Tani
        User::create([
            'name' => 'Pak Tani Makmur',
            'email' => 'mitra@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'mitra',
            'phone' => '08123456789',
            'address' => 'Sawah Subur, Bandung'
        ]);

        // 2. Akun Testing untuk Pembeli Umum
        User::create([
            'name' => 'Diska Pembeli',
            'email' => 'diska@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'pembeli',
            'phone' => '08998877665',
            'address' => 'Jl. Raya No. 1'
        ]);
    }
}