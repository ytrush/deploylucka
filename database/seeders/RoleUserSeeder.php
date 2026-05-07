<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed users for each available role.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@eduweb.test',
                'role' => User::ROLE_SUPER_ADMIN,
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@eduweb.test',
                'role' => User::ROLE_ADMIN,
            ],
            [
                'name' => 'User',
                'email' => 'user@eduweb.test',
                'role' => User::ROLE_USER,
            ],
        ];

        foreach ($users as $seedUser) {
            User::updateOrCreate(
                ['email' => $seedUser['email']],
                [
                    'name' => $seedUser['name'],
                    'password' => Hash::make('password'),
                    'role' => $seedUser['role'],
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
