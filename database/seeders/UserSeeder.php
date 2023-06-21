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
            'first_name'        => 'Admin',
            'last_name'         => 'User',
            'nickname'          => 'admin_user',
            'email'             => 'management@example.com',
            'mobile'            => '+390 57 123 4567',
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'email_verified_at' => now(),
        ]);

        // 2
        User::query()->create([
            'role'              => RolesEnum::USER->value,
            'first_name'        => 'User',
            'last_name'         => 'Operator',
            'nickname'          => 'user_operator',
            'email'             => 'user@example.com',
            'mobile' => '+380 66 123 4567',
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'email_verified_at' => now(),
        ]);
    }
}
