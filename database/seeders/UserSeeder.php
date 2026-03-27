<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Superadmin',
                'email' => 'superadmin@lpmunsika.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => 'superadmin',
            ],
            [
                'name' => 'Redaktur',
                'email' => 'lpmunsika@gmail.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => 'editor',
            ],
            [
                'name' => 'General Manager',
                'email' => 'gm@lpmunsika.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => 'general-manager',
            ],
            [
                'name' => 'Pengunjung',
                'email' => 'pengunjung@lpmunsika.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'role' => 'visitor',
            ]
        ];

        foreach ($users as $user) {
            $new_user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
                'email_verified_at' => $user['email_verified_at'],
            ]);

            $new_user->addRole($user['role']);
        }
    }
}
