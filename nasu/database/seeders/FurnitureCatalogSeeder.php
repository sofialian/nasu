<?php

namespace Database\Seeders;

use App\Models\Furniture;
use Illuminate\Database\Seeder;

class FurnitureCatalogSeeder extends Seeder
{
    public function run()
    {
        $shopItems = [
            [
                'name' => 'Silla Básica',
                'description' => 'Una silla básica para tu habitación',
                'price' => 100,
                'image_path' => 'furniture/chair.png',
                'width' => 50,
                'height' => 50,
                'is_purchasable' => true,
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mesa de Trabajo',
                'description' => 'Una mesa para trabajar',
                'price' => 200,
                'image_path' => 'furniture/table.png',
                'width' => 80,
                'height' => 60,
                'is_purchasable' => true,
                'is_default' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Add more shop items...

            // Default free items (not purchasable, given on registration)
            [
                'name' => 'Silla Inicial',
                'price' => 0,
                'image_path' => 'furniture/basic-chair.png',
                'width' => 50,
                'height' => 50,
                'description' => 'Tu primera silla',
                'is_purchasable' => false,
                'is_default' => true
            ],
            [
                'name' => 'Mesa Inicial',
                'price' => 0,
                'image_path' => 'furniture/basic-table.png',
                'width' => 80,
                'height' => 60,
                'description' => 'Tu primera mesa',
                'is_purchasable' => false,
                'is_default' => true
            ]
        ];

        foreach ($shopItems as $item) {
            Furniture::firstOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
