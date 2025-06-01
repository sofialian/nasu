<?php

namespace Database\Seeders;

use App\Models\Furniture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class FurnitureCatalogSeeder extends Seeder
{
    // database/seeders/FurnitureCatalogSeeder.php
    public function run()
    {
        $shopItems = [
            // Shop items (purchasable)
            [
                'name' => 'Silla Básica',
                'description' => 'Una silla básica para tu habitación',
                'price' => 100, // Price in beans
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

            // Default free items (given on registration)
            [
                'name' => 'Silla Inicial',
                'description' => 'Tu primera silla',
                'price' => 0, // Must include price even if 0
                'image_path' => 'furniture/basic-chair.png',
                'width' => 50,
                'height' => 50,
                'is_purchasable' => false,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mesa Inicial',
                'description' => 'Tu primera mesa',
                'price' => 0, // Must include price even if 0
                'image_path' => 'furniture/basic-table.png',
                'width' => 80,
                'height' => 60,
                'is_purchasable' => false,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($shopItems as $item) {
            try {
                Furniture::firstOrCreate(
                    ['name' => $item['name']],
                    $item
                );
            } catch (\Exception $e) {
                Log::error("Failed to create furniture: {$e->getMessage()}", $item);
            }
        }
    }
}
