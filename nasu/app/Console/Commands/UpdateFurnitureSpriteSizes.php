<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Furniture;
use Intervention\Image\Facades\Image;

class UpdateFurnitureSpriteSizes extends Command
{
    protected $signature = 'furniture:update-sprite-sizes';
    protected $description = 'Actualiza sprite_width y sprite_height para muebles según imagen y columnas';

    public function handle()
    {
        $this->info('Actualizando tamaños de sprites para muebles...');

        $furnitures = Furniture::all();

        foreach ($furnitures as $furniture) {
            $imagePath = public_path($furniture->image_path);

            if (!file_exists($imagePath)) {
                $this->warn("Imagen no encontrada para {$furniture->name} ({$imagePath})");
                continue;
            }

            $img = Image::make($imagePath);

            $totalWidth = $img->width();
            $totalHeight = $img->height();

            $columns = $furniture->sprite_columns ?? 1;
            if ($columns <= 0) $columns = 1;

            $frameWidth = intval($totalWidth / $columns);
            $frameHeight = $totalHeight;

            $furniture->sprite_width = $frameWidth;
            $furniture->sprite_height = $frameHeight;
            $furniture->save();

            $this->info("Actualizado {$furniture->name}: sprite_width={$frameWidth}, sprite_height={$frameHeight}");
        }

        $this->info('Proceso terminado.');
    }
}
