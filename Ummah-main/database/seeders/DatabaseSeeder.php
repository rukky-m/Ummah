<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'System Admin',
                'email' => 'admin@ummah.com',
                'email_verified_at' => now(),
                'password' => 'password', // Automatically hashed by User model cast
                'role' => 'admin',
                'approval_order' => 1,
            ],
            [
                'name' => 'Committee Member',
                'email' => 'committee@ummah.com',
                'email_verified_at' => now(),
                'password' => 'password',
                'role' => 'admin',
                'approval_order' => 2,
            ],
            [
                'name' => 'Member',
                'email' => 'member@ummah.com',
                'email_verified_at' => now(),
                'password' => 'password',
                'role' => 'member',
                'approval_order' => 3,
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
