<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomItem extends Model
{

    // In app/Models/RoomItem.php
    protected $casts = [
        'furniture_id' => 'integer',
        'user_furniture_id' => 'integer',
        'x_position' => 'integer',
        'y_position' => 'integer',
        'rotation' => 'integer'
    ];
    protected $fillable = [
        'room_id',
        'user_furniture_id',
        'x_position',
        'y_position',
        'rotation'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function userFurniture(): BelongsTo
    {
        return $this->belongsTo(UserFurniture::class, 'user_furniture_id');
    }

    public function furniture()
    {
        return $this->hasOneThrough(
            Furniture::class,
            UserFurniture::class,
            'id', // Foreign key on user_furniture table
            'id', // Foreign key on furniture table
            'user_furniture_id', // Local key on room_items table
            'furniture_id' // Local key on user_furniture table
        );
    }

    // Accessor for easy furniture access
    public function getFurnitureAttribute()
    {
        return $this->furniture()->first();
    }
}
