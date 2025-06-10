<?php

namespace Database\Seeders;

use App\Models\Furniture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class FurnitureCatalogSeeder extends Seeder
{
    // database/seeders/FurnitureCatalogSeeder.php
    // database/seeders/FurnitureCatalogSeeder.php
public function run()
{
    $shopItems = [
        // Default items (given on registration)
        [
            'name' => 'Cama Simple',
            'description' => 'Una cama básica para descansar',
            'price' => 0,
            'image_path' => 'furniture/basic-bed.png',
            'width' => 80,
            'height' => 120,
            'is_purchasable' => false,
            'is_default' => true,
            'default_x' => 200,
            'default_y' => 300
        ],
        [
            'name' => 'Escritorio Básico',
            'description' => 'Un escritorio para trabajar',
            'price' => 0,
            'image_path' => 'furniture/basic-desk.png',
            'width' => 100,
            'height' => 60,
            'is_purchasable' => false,
            'is_default' => true,
            'default_x' => 400,
            'default_y' => 200
        ],
        [
            'name' => 'Silla Inicial',
            'description' => 'Tu primera silla',
            'price' => 0,
            'image_path' => 'furniture/basic-chair.png',
            'width' => 50,
            'height' => 50,
            'is_purchasable' => false,
            'is_default' => true
        ],
        // ... add more items as needed
    ];

    foreach ($shopItems as $item) {
        Furniture::firstOrCreate(
            ['name' => $item['name']],
            $item
        );
    }
}
}
