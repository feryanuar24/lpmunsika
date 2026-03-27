<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'name' => 'Slider 1',
                'banner' => 'dummy/1.jpg',
                'description' => 'Deskripsi untuk slider 1',
            ],
            [
                'name' => 'Slider 2',
                'banner' => 'dummy/2.jpg',
                'description' => 'Deskripsi untuk slider 2',
            ],
            [
                'name' => 'Slider 3',
                'banner' => 'dummy/3.jpg',
                'description' => 'Deskripsi untuk slider 3',
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}
