<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class AciaaBannerSeeder extends Seeder
{
    public function run(): void
    {
        if (Banner::count() == 0) {
            $banners = [
                [
                    'title' => "Define Your Elegance,\nEmbrace Your Style",
                    'subtitle' => 'New Collection 2025',
                    'description' => 'Curated contemporary boutique apparel for the modern, confident woman.',
                    'image' => 'banners/banner_1.png',
                    'link' => '/products',
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'title' => "Timeless Fashion,\nModern Spirit",
                    'subtitle' => 'Premium Women\'s Fashion',
                    'description' => 'Discover our exclusive collection of premium garments crafted for the contemporary woman.',
                    'image' => 'banners/banner_2.png',
                    'link' => '/products',
                    'order' => 2,
                    'is_active' => true,
                ],
            ];

            foreach ($banners as $banner) {
                Banner::create($banner);
            }
        }
    }
}
