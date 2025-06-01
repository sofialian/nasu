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
        'is_purchasable',
        'is_default'
    ];

    public function userFurniture(): HasMany
    {
        return $this->hasMany(UserFurniture::class);
    }
}