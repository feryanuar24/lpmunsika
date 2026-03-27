<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'dashboard-management',
                'display_name' => 'Manajemen Dashboard',
                'description' => 'Akses untuk melihat dan mengelola dashboard, termasuk melihat statistik dan laporan.'
            ],
            [
                'name' => 'tags-management',
                'display_name' => 'Manajemen Tag',
                'description' => 'Akses untuk mengelola tag, termasuk membuat, mengedit, dan menghapus tag.'
            ],
            [
                'name' => 'articles-management',
                'display_name' => 'Manajemen Artikel',
                'description' => 'Akses untuk mengelola artikel, termasuk membuat, mengedit, dan menghapus artikel.'
            ],
            [
                'name' => 'embeds-management',
                'display_name' => 'Manajemen Embed',
                'description' => 'Akses untuk mengelola embed, termasuk membuat, mengedit, dan menghapus embed.'
            ],
            [
                'name' => 'sliders-management',
                'display_name' => 'Manajemen Sliders',
                'description' => 'Akses untuk mengelola sliders, termasuk membuat, mengedit, dan menghapus sliders.'
            ],
            [
                'name' => 'footers-management',
                'display_name' => 'Manajemen Footer',
                'description' => 'Akses untuk mengelola footer, termasuk membuat, mengedit, dan menghapus footer.'
            ],
            [
                'name' => 'permission-role-management',
                'display_name' => 'Manajemen Permission & Role',
                'description' => 'Akses untuk mengelola permissions dan roles, termasuk membuat, mengedit, dan menghapus permissions dan roles.'
            ],
            [
                'name' => 'users-management',
                'display_name' => 'Manajemen Pengguna',
                'description' => 'Akses untuk mengelola pengguna, termasuk membuat, mengedit, dan menghapus pengguna.'
            ],
            [
                'name' => 'categories-management',
                'display_name' => 'Manajemen Kategori',
                'description' => 'Akses untuk mengelola kategori, termasuk membuat, mengedit, dan menghapus kategori.'
            ],
            [
                'name' => 'platforms-management',
                'display_name' => 'Manajemen Platform',
                'description' => 'Akses untuk mengelola platform, termasuk membuat, mengedit, dan menghapus platform.'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
