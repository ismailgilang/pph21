<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User dengan role SDM
        User::factory()->create([
            'name' => 'SDM',
            'email' => 'sdm@gmail.com',
            'password' => Hash::make('sdm123'),
            'role' => 'sdm',
        ]);

        // User dengan role Kepala Cabang
        User::factory()->create([
            'name' => 'Kepala Cabang',
            'email' => 'kepalacabang@gmail.com',
            'password' => Hash::make('cabang123'),
            'role' => 'kepala cabang',
        ]);

        // User dengan role Keuangan
        User::factory()->create([
            'name' => 'Keuangan',
            'email' => 'keuangan@gmail.com',
            'password' => Hash::make('keuangan123'),
            'role' => 'keuangan',
        ]);
    }
}
