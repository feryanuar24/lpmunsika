<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            ['name' => 'Banner 1', 'banner' => 'assets/media/images/2600x1200/1.png', 'description' => 'Gambar 1'],
            ['name' => 'Banner 2', 'banner' => 'assets/media/images/2600x1200/2.png', 'description' => 'Gambar 2'],
            ['name' => 'Banner 3', 'banner' => 'assets/media/images/2600x1200/2.png', 'description' => 'Gambar 3'],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
