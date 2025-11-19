<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Berita', 'slug' => 'berita', 'description' => 'Kategori untuk artikel berita'],
            ['name' => 'Buletin', 'slug' => 'buletin', 'description' => 'Kategori untuk artikel buletin'],
            ['name' => 'Karya Mahasiswa', 'slug' => 'karya-mahasiswa', 'description' => 'Kategori untuk artikel karya mahasiswa'],
            ['name' => 'Resensi Buku', 'slug' => 'resensi-buku', 'description' => 'Kategori untuk artikel resensi buku'],
            ['name' => 'Review Film', 'slug' => 'review-film', 'description' => 'Kategori untuk artikel review film'],
            ['name' => 'Opini', 'slug' => 'opini', 'description' => 'Kategori untuk artikel opini'],
            ['name' => 'Esai', 'slug' => 'esai', 'description' => 'Kategori untuk artikel esai'],
            ['name' => 'Artikel', 'slug' => 'artikel', 'description' => 'Kategori untuk artikel umum'],
            ['name' => 'Puisi', 'slug' => 'puisi', 'description' => 'Kategori untuk artikel puisi'],
            ['name' => 'Cerpen', 'slug' => 'cerpen', 'description' => 'Kategori untuk artikel cerpen'],
            ['name' => 'Gaya Mahasiswa', 'slug' => 'gaya-mahasiswa', 'description' => 'Kategori untuk gaya mahasiswa'],
            ['name' => 'Produk', 'slug' => 'produk', 'description' => 'Kategori parent untuk buletin dan majalah'],
            ['name' => 'Majalah', 'slug' => 'majalah', 'description' => 'Kategori untuk artikel majalah'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
