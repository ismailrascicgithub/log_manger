<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => UserRole::ADMIN->value
        ]);

        User::create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'password' => Hash::make('editor123'),
            'role' => UserRole::EDITOR->value
        ]);


        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'role' => UserRole::EDITOR->value
        ]);
    }
}
