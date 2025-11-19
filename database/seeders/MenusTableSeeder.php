<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            ['name' => 'Dashboard', 'parent' => null, 'url' => '/dashboard', 'icon' => 'ki-graph', 'description' => 'Halaman utama dashboard'],
            ['name' => 'Manajemen Pengguna', 'parent' => null, 'url' => null, 'icon' => null, 'description' => 'Menu parent untuk manajemen pengguna'],
            ['name' => 'Profil', 'parent' => 'Manajemen Pengguna', 'url' => '/profile', 'icon' => 'ki-user', 'description' => 'Halaman untuk melihat profil pengguna'],
            ['name' => 'Pengguna', 'parent' => 'Manajemen Pengguna', 'url' => '/users', 'icon' => 'ki-users', 'description' => 'Halaman untuk melihat daftar pengguna'],
            ['name' => 'Manajemen Konten', 'parent' => null, 'url' => null, 'icon' => null, 'description' => 'Menu parent untuk manajemen konten'],
            ['name' => 'Artikel', 'parent' => 'Manajemen Konten', 'url' => '/articles', 'icon' => 'ki-document', 'description' => 'Halaman untuk manajemen artikel'],
            ['name' => 'Kategori', 'parent' => 'Manajemen Konten', 'url' => '/categories', 'icon' => 'ki-category', 'description' => 'Halaman untuk manajemen kategori'],
            ['name' => 'Tag', 'parent' => 'Manajemen Konten', 'url' => '/tags', 'icon' => 'ki-tag', 'description' => 'Halaman untuk manajemen tag'],
            ['name' => 'Manajemen Widget', 'parent' => null, 'url' => null, 'icon' => null, 'description' => 'Menu parent untuk manajemen widget'],
            ['name' => 'Platform', 'parent' => 'Manajemen Widget', 'url' => '/platforms', 'icon' => 'ki-social-media', 'description' => 'Halaman untuk manajemen platform'],
            ['name' => 'Embed', 'parent' => 'Manajemen Widget', 'url' => '/embeds', 'icon' => 'ki-fasten', 'description' => 'Halaman untuk manajemen embed'],
            ['name' => 'Sliders', 'parent' => 'Manajemen Widget', 'url' => '/sliders', 'icon' => 'ki-slider', 'description' => 'Halaman untuk manajemen sliders'],
            ['name' => 'Pengaturan', 'parent' => null, 'url' => null, 'icon' => null, 'description' => 'Menu parent untuk pengaturan sistem'],
            ['name' => 'Permissions', 'parent' => 'Pengaturan', 'url' => '/permissions', 'icon' => 'ki-lock', 'description' => 'Halaman untuk manajemen permissions'],
            ['name' => 'Roles', 'parent' => 'Pengaturan', 'url' => '/roles', 'icon' => 'ki-key', 'description' => 'Halaman untuk manajemen roles'],
            ['name' => 'Permission Role', 'parent' => 'Pengaturan', 'url' => '/permission-role', 'icon' => 'ki-shield', 'description' => 'Halaman untuk manajemen permission role'],
            ['name' => 'Footer', 'parent' => 'Manajemen Widget', 'url' => '/footers', 'icon' => 'ki-tablet-text-down', 'description' => null],
        ];

        $created = [];

        foreach ($menus as $m) {
            $parentId = null;
            if (!empty($m['parent'])) {
                $parent = $created[$m['parent']] ?? Menu::where('name', $m['parent'])->first();
                $parentId = $parent->id ?? null;
            }

            $menu = Menu::create([
                'parent_id' => $parentId,
                'name' => $m['name'],
                'url' => $m['url'],
                'icon' => $m['icon'],
                'description' => $m['description'],
            ]);

            $created[$m['name']] = $menu;
        }
    }
}
