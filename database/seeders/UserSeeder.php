<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1
        User::query()->create([
            'role'              => RolesEnum::ADMIN->value,
            'name'              => 'Admin User',
            'email'             => 'admin@example.com',
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'email_verified_at' => now(),
        ]);

        // 2
        User::query()->create([
            'role'              => RolesEnum::USER->value,
            'name'              => 'User Operator',
            'email'             => 'user@example.com',
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'email_verified_at' => now(),
        ]);
    }
}
