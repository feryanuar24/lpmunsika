<?php

namespace Database\Seeders;

use App\Models\Embed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmbedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $embeds = [
            [
                'platform_id' => 1,
                'title' => 'Company Profile LPM Unsika 2025',
                'embed_code' => '<iframe class="w-full" height="315" src="https://www.youtube.com/embed/0jd3CjEjeaY?si=JG1P2Jj9LQPdHvEA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'description' => 'Video profil LPM Unsika'
            ],
            [
                'platform_id' => 1,
                'title' => 'MEET THE LEGEND: BANG BIN',
                'embed_code' => '<iframe class="w-full" height="315" src="https://www.youtube.com/embed/TmtRFd0GZEI?si=I3HdkHRA_TESbmuk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'description' => 'Video profil Bang Bin, salah satu pendiri LPM Unsika'
            ],
            [
                'platform_id' => 1,
                'title' => '[NEWSIKA] Unsika Mode Musim Hujan',
                'embed_code' => '<iframe class="w-full" height="315" src="https://www.youtube.com/embed/2vCOhSc-lPg?si=GPoEvpwu-5CXDbjn" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>',
                'description' => 'Video berita tentang Unsika Mode Musim Hujan'
            ],
            [
                'platform_id' => 2,
                'title' => '#82 Keluh Kesah Mahasiswa PP (Pulang Pergi): Realita dan Perjuangan',
                'embed_code' => '<iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/episode/6ISoyz4JvpHyPk13erGrNk/video?utm_source=generator" class="w-full" height="351" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>',
                'description' => 'Podcast tentang keluh kesah mahasiswa yang harus pulang pergi untuk kuliah'
            ],
            [
                'platform_id' => 2,
                'title' => '#83 Mahasiswa Entrepreneur: Dari Kelas Kuliah ke Dunia Bisnis',
                'embed_code' => '<iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/episode/2bBS3YY0O1VggTYSPQxiOq?utm_source=generator" class="w-full" height="352" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>',
                'description' => 'Podcast tentang mahasiswa yang berwirausaha sambil kuliah'
            ],
            [
                'platform_id' => 2,
                'title' => '#84 Bincang-Bincang Soal Natal',
                'embed_code' => '<iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/episode/2gx79ini2RPATHrJ3P92ZE/video?utm_source=generator" class="w-full" height="351" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>',
                'description' => 'Podcast tentang perayaan Natal di kalangan mahasiswa'
            ]
        ];

        foreach ($embeds as $embed) {
            Embed::create($embed);
        }
    }
}
