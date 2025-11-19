<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            ['name' => 'Youtube', 'url' => 'https://youtube.com/@lpmunsika', 'icon' => 'ki-youtube', 'description' => 'Platform resmi LPM Unsika di Youtube'],
            ['name' => 'Spotify', 'url' => 'https://open.spotify.com/show/3PSxdzFHQz77vVRZfxBRdS', 'icon' => 'ki-spotify', 'description' => 'Platform resmi LPM Unsika di Spotify'],
            ['name' => 'Instagram', 'url' => 'https://instagram.com/lpmunsika', 'icon' => 'ki-instagram', 'description' => 'Platform resmi LPM Unsika di Instagram'],
            ['name' => 'Twitter', 'url' => 'https://twitter.com/lpmunsika', 'icon' => 'ki-twitter', 'description' => 'Platform resmi LPM Unsika di Twitter'],
            ['name' => 'Facebook', 'url' => 'https://facebook.com/lpmunsika', 'icon' => 'ki-facebook', 'description' => 'Platform resmi LPM Unsika di Facebook'],
            ['name' => 'LinkedIn', 'url' => 'https://id.linkedin.com/company/lembaga-pers-mahasiswa-unsika', 'icon' => 'ki-social-media', 'description' => 'Platform resmi LPM Unsika di LinkedIn'],
            ['name' => 'TikTok', 'url' => 'https://www.tiktok.com/@lpmunsika', 'icon' => 'ki-tiktok', 'description' => 'Platform resmi LPM Unsika di TikTok'],
        ];

        foreach ($platforms as $platform) {
            Platform::create($platform);
        }
    }
}
