<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultFurnitureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // database/seeders/DefaultFurnitureSeeder.php


        \App\Models\Furniture::create([
            'name' => 'Starter Chair',
            'image_path' => 'furniture/chair.png',
            'price' => 0,
            'is_default' => true,
            'metadata' => ['width' => 50, 'height' => 50]
        ]);

        // Add more default items...

    }
}
