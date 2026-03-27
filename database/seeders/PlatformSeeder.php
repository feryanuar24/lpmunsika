<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platforms = [
            [
                'name' => 'Youtube',
                'url' => 'https://youtube.com/@lpmresonan',
                'icon' => 'ki-youtube',
                'description' => 'Platform resmi LPM Resonan Unsika di Youtube'
            ],
            [
                'name' => 'Spotify',
                'url' => 'https://open.spotify.com/show/3PSxdzFHQz77vVRZfxBRdS',
                'icon' => 'ki-spotify',
                'description' => 'Platform resmi LPM Resonan Unsika di Spotify'
            ],
            [
                'name' => 'Instagram',
                'url' => 'https://instagram.com/lpmresonan',
                'icon' => 'ki-instagram',
                'description' => 'Platform resmi LPM Resonan Unsika di Instagram'
            ],
            [
                'name' => 'Twitter',
                'url' => 'https://twitter.com/lpmresonan',
                'icon' => 'ki-twitter',
                'description' => 'Platform resmi LPM Resonan Unsika di Twitter'
            ],
            [
                'name' => 'Facebook',
                'url' => 'https://facebook.com/lpmresonan',
                'icon' => 'ki-facebook',
                'description' => 'Platform resmi LPM Resonan Unsika di Facebook'
            ],
            [
                'name' => 'LinkedIn',
                'url' => 'https://id.linkedin.com/company/lembaga-pers-mahasiswa-unsika',
                'icon' => 'ki-social-media',
                'description' => 'Platform resmi LPM Resonan Unsika di LinkedIn'
            ],
            [
                'name' => 'TikTok',
                'url' => 'https://www.tiktok.com/@lpmresonan',
                'icon' => 'ki-tiktok',
                'description' => 'Platform resmi LPM Resonan Unsika di TikTok'
            ],
        ];

        foreach ($platforms as $platform) {
            Platform::create($platform);
        }
    }
}
