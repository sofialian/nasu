<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Furniture extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'width',
        'height',
        'category',
        'is_purchasable',
        'is_default'
    ];

    public function userFurniture(): HasMany
    {
        return $this->hasMany(UserFurniture::class);
    }

    public function views()
    {
        return $this->hasMany(FurnitureView::class);
    }

    public function viewForRotation($rotation)
    {
        $view = match ((int)$rotation % 360) {
            0 => 'front',
            90 => 'right',
            180 => 'back',
            270 => 'left',
            default => 'front', // fallback
        };

        return $this->views->firstWhere('view', $view);
    }
}
