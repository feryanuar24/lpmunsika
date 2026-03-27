<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'superadmin',
                'display_name' => 'Superadmin',
                'description' => 'Superadmin memiliki akses penuh ke semua fitur.'
            ],
            [
                'name' => 'editor',
                'display_name' => 'Redaktur',
                'description' => 'Redaktur memiliki akses ke fitur dashboard dan manajemen konten.'
            ],
            [
                'name' => 'general-manager',
                'display_name' => 'General Manager',
                'description' => 'General Manager memiliki akses ke fitur dashboard.'
            ],
            [
                'name' => 'visitor',
                'display_name' => 'pengunjung',
                'description' => 'Pengunjung memiliki akses ke fitur komentar dan notifikasi.'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
