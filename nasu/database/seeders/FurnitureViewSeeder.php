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
                'image_path' => 'furniture/front-basic-chair.png',
                'width' => 48,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 1,
                'view' => 'left',
                'image_path' => 'furniture/left-basic-chair.png',
                'width' => 40,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 1,
                'view' => 'right',
                'image_path' => 'furniture/right-basic-chair.png',
                'width' => 40,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'furniture_id' => 1,
                'view' => 'back',
                'image_path' => 'furniture/back-basic-chair.png',
                'width' => 40,
                'height' => 48,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
