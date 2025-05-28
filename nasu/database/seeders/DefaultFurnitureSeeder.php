<?php

namespace Database\Seeders;

use App\Models\Furniture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultFurnitureSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Use delete() instead of truncate() to respect foreign keys
        Furniture::query()->delete();
        
        // Default furniture items
        $defaultItems = [
            [
                'name' => 'Silla Básica',
                'price' => 0,
                'is_default' => true,
                'image_path' => 'furniture/chair.png',
                'metadata' => json_encode(['width' => 50, 'height' => 50])
            ],
            [
                'name' => 'Mesa de Trabajo',
                'price' => 0,
                'is_default' => true,
                'image_path' => 'furniture/table.png',
                'metadata' => json_encode(['width' => 80, 'height' => 60])
            ],
            [
                'name' => 'Lámpara',
                'price' => 0,
                'is_default' => true,
                'image_path' => 'furniture/lamp.png',
                'metadata' => json_encode(['width' => 30, 'height' => 40])
            ]
        ];

        foreach ($defaultItems as $item) {
            Furniture::create($item);
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}