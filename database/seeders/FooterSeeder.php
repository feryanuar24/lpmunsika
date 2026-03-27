<?php

namespace Database\Seeders;

use App\Models\Footer;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $footers = [
            [
                'name' => 'Profil',
                'url' => 'https://youtu.be/0jd3CjEjeaY?si=QQoi3eNwv_AZzgRG',
                'description' => 'Video profil LPM Unsika'
            ],
            [
                'name' => 'Rekrutmen',
                'url' => 'https://bit.ly/RekrutmenTerbukaLPMUnsikaTahun2025',
                'description' => 'Formulir rekrutmen LPM Unsika'
            ],
            [
                'name' => 'Buletin 38',
                'url' => 'https://lpmunsika.com/detail/buletin-suara-unsika-edisi-38',
                'description' => 'Buletin Suara Unsika Edisi 38'
            ],
            [
                'name' => 'Kontributor',
                'url' => 'https://bit.ly/LPMUNSIKA',
                'description' => 'Bergabung menjadi kontributor LPM Unsika'
            ],
        ];

        foreach ($footers as $footer) {
            Footer::create($footer);
        }
    }
}
