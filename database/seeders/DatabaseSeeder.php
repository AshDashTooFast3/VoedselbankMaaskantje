<?php

namespace Database\Seeders;

use App\Models\Persoon;
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
        User::create([
            'email' => 'manager@maaskantje.nl',
            'name' => 'manager User',
            'password' => Hash::make('achraf123'),
            'rolename' => 'manager',
        ]);

        User::create([
            'email' => 'klant@maaskantje.nl',
            'name' => 'klant User',
            'password' => Hash::make('achraf123'),
            'rolename' => 'klant',
        ]);
    }
}
