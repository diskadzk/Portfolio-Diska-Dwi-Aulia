<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan UserSeeder dipanggil duluan karena Product butuh user_id
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
        ]);
    }
}