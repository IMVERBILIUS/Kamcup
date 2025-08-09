<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'kuku2@example.com',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Regular User',
            'email' => 'keke3@example.com',
            'password' => Hash::make('user'),
            'role' => 'user'
        ]);
    }
}
