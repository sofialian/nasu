<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Furniture extends Model
{
    protected $casts = [
        'metadata' => 'array',
        'is_purchasable' => 'boolean',
        'is_default' => 'boolean'
    ];

    protected $fillable = [
        'name',
        'image_path',
        'metadata',
        'price',
        'is_purchasable',
        'is_default'
    ];

    // Relationship to user-owned items
    public function ownedByUsers()
    {
        return $this->hasMany(UserFurniture::class);
    }

    // Helper to get dimensions
    public function getWidth()
    {
        return $this->metadata['width'] ?? 50; // Default if not set
    }

    public function getHeight()
    {
        return $this->metadata['height'] ?? 50;
    }
}
