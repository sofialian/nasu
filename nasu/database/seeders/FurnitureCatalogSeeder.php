<?php

namespace Database\Seeders;

use App\Models\furniture;
use Illuminate\Database\Seeder;

class FurnitureCatalogSeeder extends Seeder
{
    public function run()
    {
        $shopItems = [
            // Default items (free, assigned on registration)
            [
                'id' => 1,
                'name' => 'Cama Simple',
                'description' => 'Una cama básica para descansar',
                'price' => 0,
                'width' => 80,
                'height' => 60,
                'is_purchasable' => false,
                'is_default' => true,
                'category' => 'bed',
                'sprite_columns' => 1
            ],
            [
                'id' => 2,
                'name' => 'Escritorio Básico',
                'description' => 'Un escritorio para trabajar',
                'price' => 0,
                'width' => 100,
                'height' => 60,
                'is_purchasable' => false,
                'is_default' => true,
                'category' => 'table',
            ],
            [
                'id' => 3,
                'name' => 'Silla Inicial',
                'description' => 'Tu primera silla',
                'price' => 0,

                'width' => 15,
                'is_purchasable' => false,
                'is_default' => true,
                'category' => 'seating'
            ],

            // Purchasable items
            [
                'id' => 4,
                'name' => 'Planta Decorativa',
                'description' => 'Ideal para dar vida a tu habitación',
                'price' => 100,
                'width' => 40,
                'height' => 60,
                'is_purchasable' => true,
                'is_default' => false,
                'category' => 'decor'
            ],
            [
                'id' => 5,
                'name' => 'Alfombra Moderna',
                'description' => 'Una alfombra elegante y moderna',
                'price' => 250,
                'width' => 100,
                'height' => 100,
                'is_purchasable' => true,
                'is_default' => false,
                'category' => 'floor',
                'sprite_columns' => 1
            ],
            [
                'id' => 6,
                'name' => 'Estantería',
                'description' => 'Perfecta para libros o decoración',
                'price' => 450,
                'width' => 80,
                'height' => 120,
                'is_purchasable' => true,
                'is_default' => false,
                'category' => 'shelving',
            ],
        ];

        foreach ($shopItems as $item) {
            furniture::firstOrCreate(
                ['id' => 3,
                    'id' => 3,'name' => $item[
                    'name']],
                $item
            );
        }
    }
}
