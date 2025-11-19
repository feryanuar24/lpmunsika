<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'Pendidikan', 'slug' => 'pendidikan'],
            ['name' => 'Teknologi', 'slug' => 'teknologi'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan'],
            ['name' => 'Seni', 'slug' => 'seni'],
            ['name' => 'Olahraga', 'slug' => 'olahraga'],
            ['name' => 'Musik', 'slug' => 'musik'],
            ['name' => 'Film', 'slug' => 'film'],
            ['name' => 'Literatur', 'slug' => 'literatur'],
            ['name' => 'Sosial', 'slug' => 'sosial'],
            ['name' => 'Politik', 'slug' => 'politik'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
