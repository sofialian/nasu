<?php

namespace Database\Seeders;

use App\Models\Furniture;
use Illuminate\Database\Seeder;

class FurnitureCatalogSeeder extends Seeder
{
    public function run()
    {
        $shopItems = [
            // Default items (free, assigned on registration)
            [
                'name' => 'Cama Simple',
                'description' => 'Una cama básica para descansar',
                'price' => 0,
                'image_path' => 'furniture/basic-bed.png',
                'width' => 80,
                'height' => 120,
                'is_purchasable' => false,
                'is_default' => true,
                'category' => 'bed'
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
                'category' => 'table'
            ],
            [
                'name' => 'Silla Inicial',
                'description' => 'Tu primera silla',
                'price' => 0,
                'image_path' => 'furniture/basic-chair.png',
                'width' => 50,
                'height' => 50,
                'is_purchasable' => false,
                'is_default' => true,
                'category' => 'seating'
            ],

            // Purchasable items
            [
                'name' => 'Planta Decorativa',
                'description' => 'Ideal para dar vida a tu habitación',
                'price' => 20,
                'image_path' => 'furniture/plant.png',
                'width' => 40,
                'height' => 60,
                'is_purchasable' => true,
                'is_default' => false,
                'category' => 'decor'
            ],
            [
                'name' => 'Alfombra Moderna',
                'description' => 'Una alfombra elegante y moderna',
                'price' => 35,
                'image_path' => 'furniture/rug.png',
                'width' => 100,
                'height' => 100,
                'is_purchasable' => true,
                'is_default' => false,
                'category' => 'floor'
            ],
            [
                'name' => 'Estantería',
                'description' => 'Perfecta para libros o decoración',
                'price' => 45,
                'image_path' => 'furniture/shelf.png',
                'width' => 80,
                'height' => 120,
                'is_purchasable' => true,
                'is_default' => false,
                'category' => 'shelving'
            ],
        ];

        foreach ($shopItems as $item) {
            Furniture::firstOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
