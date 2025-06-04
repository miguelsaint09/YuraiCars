<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteAssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SiteAsset::updateOrCreate(
            ['key' => 'hero_car_image'],
            [
                'name' => 'Imagen del Carro Hero',
                'url' => asset('images/Car3d.png'),
                'alt_text' => 'Supercar de lujo moderno',
                'is_active' => true
            ]
        );
    }
}
