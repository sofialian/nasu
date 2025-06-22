<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FurnitureViewSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('furniture_views')->insert([
            [
                'furniture_id' => 1,
                'view' => 'front',
                'image_path' => 'furniture/cama-simple-front.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'furniture_id' => 2,
                'view' => 'front',
                'image_path' => 'furniture/front-basic-desk.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'furniture_id' => 3,
                'view' => 'front',
                'image_path' => 'furniture/front-basic-chair.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 3,
                'view' => 'right',
                'image_path' => 'furniture/right-basic-chair.png',
                'width' => 40,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 3,
                'view' => 'left',
                'image_path' => 'furniture/left-basic-chair.png',
                'width' => 40,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 3,
                'view' => 'back',
                'image_path' => 'furniture/back-basic-chair.png',
                'width' => 40,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'furniture_id' => 4,
                'view' => 'front',
                'image_path' => 'furniture/front-plant.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 4,
                'view' => 'right',
                'image_path' => 'furniture/right-plant.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 4,
                'view' => 'left',
                'image_path' => 'furniture/left-plant.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 4,
                'view' => 'back',
                'image_path' => 'furniture/back-plant.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 5,
                'view' => 'front',
                'image_path' => 'furniture/rug.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'furniture_id' => 6,
                'view' => 'front',
                'image_path' => 'furniture/front-simple-cupboard.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 6,
                'view' => 'right',
                'image_path' => 'furniture/right-simple-cupboard.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 6,
                'view' => 'left',
                'image_path' => 'furniture/left-simple-cupboard.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 6,
                'view' => 'back',
                'image_path' => 'furniture/back-simple-cupboard.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
