<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Pendidikan', 'slug' => 'pendidikan', 'description' => 'Tag untuk artikel yang berkaitan dengan pendidikan'],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'description' => 'Tag untuk artikel yang berkaitan dengan teknologi'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'description' => 'Tag untuk artikel yang berkaitan dengan kesehatan'],
            ['name' => 'Seni', 'slug' => 'seni', 'description' => 'Tag untuk artikel yang berkaitan dengan seni'],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'description' => 'Tag untuk artikel yang berkaitan dengan olahraga'],
            ['name' => 'Musik', 'slug' => 'musik', 'description' => 'Tag untuk artikel yang berkaitan dengan musik'],
            ['name' => 'Film', 'slug' => 'film', 'description' => 'Tag untuk artikel yang berkaitan dengan film'],
            ['name' => 'Literatur', 'slug' => 'literatur', 'description' => 'Tag untuk artikel yang berkaitan dengan literatur'],
            ['name' => 'Sosial', 'slug' => 'sosial', 'description' => 'Tag untuk artikel yang berkaitan dengan sosial'],
            ['name' => 'Politik', 'slug' => 'politik', 'description' => 'Tag untuk artikel yang berkaitan dengan politik'],
            ['name' => 'Ekonomi', 'slug' => 'ekonomi', 'description' => 'Tag untuk artikel yang berkaitan dengan ekonomi dan bisnis'],
            ['name' => 'Lingkungan', 'slug' => 'lingkungan', 'description' => 'Tag untuk artikel yang berkaitan dengan lingkungan hidup'],
            ['name' => 'Hukum', 'slug' => 'hukum', 'description' => 'Tag untuk artikel yang berkaitan dengan hukum dan peraturan'],
            ['name' => 'Internasional', 'slug' => 'internasional', 'description' => 'Tag untuk artikel yang berkaitan dengan berita internasional'],
            ['name' => 'Kuliner', 'slug' => 'kuliner', 'description' => 'Tag untuk artikel yang berkaitan dengan makanan dan minuman'],
            ['name' => 'Travel', 'slug' => 'travel', 'description' => 'Tag untuk artikel yang berkaitan dengan wisata dan perjalanan'],
            ['name' => 'Opini', 'slug' => 'opini', 'description' => 'Tag untuk artikel opini dan editorial'],
            ['name' => 'Inspirasi', 'slug' => 'inspirasi', 'description' => 'Tag untuk artikel inspiratif dan motivasi'],
            ['name' => 'Startup', 'slug' => 'startup', 'description' => 'Tag untuk artikel tentang startup dan inovasi'],
            ['name' => 'Pemerintahan', 'slug' => 'pemerintahan', 'description' => 'Tag untuk artikel tentang pemerintahan dan kebijakan publik'],
            ['name' => 'Pendidikan Tinggi', 'slug' => 'pendidikan-tinggi', 'description' => 'Tag untuk artikel tentang universitas dan pendidikan tinggi'],
            ['name' => 'Sejarah', 'slug' => 'sejarah', 'description' => 'Tag untuk artikel sejarah'],
            ['name' => 'Agama', 'slug' => 'agama', 'description' => 'Tag untuk artikel tentang agama dan kepercayaan'],
            ['name' => 'Gaya Hidup', 'slug' => 'gaya-hidup', 'description' => 'Tag untuk artikel gaya hidup dan tren'],
            ['name' => 'Otomotif', 'slug' => 'otomotif', 'description' => 'Tag untuk artikel otomotif dan kendaraan'],
            ['name' => 'Properti', 'slug' => 'properti', 'description' => 'Tag untuk artikel properti dan real estate'],
            ['name' => 'Sains', 'slug' => 'sains', 'description' => 'Tag untuk artikel sains dan pengetahuan'],
            ['name' => 'Humaniora', 'slug' => 'humaniora', 'description' => 'Tag untuk artikel humaniora'],
            ['name' => 'Ekspresi', 'slug' => 'ekspresi', 'description' => 'Tag untuk artikel ekspresi diri'],
            ['name' => 'Event', 'slug' => 'event', 'description' => 'Tag untuk artikel tentang event dan kegiatan'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
