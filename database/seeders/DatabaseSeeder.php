<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo users
        User::create([
            'name' => 'Demo Supplier',
            'email' => 'supplier@example.com',
            'password' => Hash::make('password'),
            'role' => 'supplier',
        ]);

        User::create([
            'name' => 'Demo Security',
            'email' => 'security@example.com',
            'password' => Hash::make('password'),
            'role' => 'security',
        ]);

        User::create([
            'name' => 'Demo Export-Import',
            'email' => 'export@example.com',
            'password' => Hash::make('password'),
            'role' => 'export_import',
        ]);

        User::create([
            'name' => 'Demo Warehouse',
            'email' => 'warehouse@example.com',
            'password' => Hash::make('password'),
            'role' => 'warehouse',
        ]);
    }
}
