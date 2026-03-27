<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Berita',
                'slug' => 'berita',
                'description' => 'Berisi berita terbaru, informasi aktual, dan perkembangan penting yang terjadi di lingkungan kampus maupun luar kampus.'
            ],
            [
                'name' => 'Produk',
                'slug' => 'produk',
                'description' => 'Kategori parent yang menampung berbagai produk cetak yang didigitalisasi, seperti buletin dan majalah.'
            ],
            [
                'name' => 'Buletin',
                'slug' => 'buletin',
                'description' => 'Berisi produk cetak buletin yang didigitalisasi, memuat kajian yang mendalam tentang berbagai topik, dengan fokus pada isu-isu aktual dan tren terkini.'
            ],
            [
                'name' => 'Majalah',
                'slug' => 'majalah',
                'description' => 'Berisi produk cetak majalah yang didigitalisasi, memuat kajian yang mendalam tentang berbagai topik, dengan fokus pada isu-isu aktual dan tren terkini.'
            ],
            [
                'name' => 'Karya Mahasiswa',
                'slug' => 'karya-mahasiswa',
                'description' => 'Kategori parent untuk menampung berbagai karya mahasiswa, seperti resensi buku, review film, opini, esai, artikel, puisi, cerpen, dsb.'
            ],
            [
                'name' => 'Resensi Buku',
                'slug' => 'resensi-buku',
                'description' => 'Memuat tulisan yang berisikan resensi buku yang membahas, mengulas, dan merekomendasikan berbagai buku bacaan.'
            ],
            [
                'name' => 'Review Film',
                'slug' => 'review-film',
                'description' => 'Berisi tulisan yang mengulas film, baik dari segi cerita, pesan, maupun aspek sinematografi.'
            ],
            [
                'name' => 'Opini',
                'slug' => 'opini',
                'description' => 'Menyajikan tulisan opini, gagasan, dan sudut pandang penulis terhadap isu-isu aktual atau fenomena tertentu.'
            ],
            [
                'name' => 'Esai',
                'slug' => 'esai',
                'description' => 'Kategori untuk tulisan esai yang berisi pemikiran, refleksi, atau analisis mendalam mengenai berbagai topik.'
            ],
            [
                'name' => 'Artikel',
                'slug' => 'artikel',
                'description' => 'Menampung tulisan artikel yang membahas berbagai topik, baik yang bersifat informatif, edukatif, maupun analitis.'
            ],
            [
                'name' => 'Puisi',
                'slug' => 'puisi',
                'description' => 'Berisi karya puisi yang mengekspresikan perasaan, pengalaman, dan imajinasi penulis dalam bentuk sastra.'
            ],
            [
                'name' => 'Cerpen',
                'slug' => 'cerpen',
                'description' => 'Memuat kumpulan cerita pendek hasil karya penulis yang mengangkat berbagai tema kehidupan.'
            ],
            [
                'name' => 'Gaya Mahasiswa',
                'slug' => 'gaya-mahasiswa',
                'description' => 'Kategori yang menampilkan tulisan tentang gaya hidup, tren, dan aktivitas khas mahasiswa.'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
