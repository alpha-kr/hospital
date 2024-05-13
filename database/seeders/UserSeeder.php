<?php

namespace Database\Seeders;

use Domain\Auth\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        $user->tokens()->create([
            'name' => 'Admin Token',
            'token' => hash('sha256', 'GgFjt0EkDfieG1Kc7EvYl9AZU6ND7q3v'),
            'abilities' => ['*'],
            'expires_at' => now()->addYear(),
        ]);
    }
}
