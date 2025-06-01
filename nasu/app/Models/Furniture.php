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

    // app/Models/Furniture.php
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($furniture) {
            $required = ['name', 'description', 'price', 'image_path'];
            foreach ($required as $field) {
                if (empty($furniture->{$field})) {
                    throw new \Exception("Furniture {$field} is required");
                }
            }
        });
    }

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
