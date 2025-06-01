<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['user_id', 'theme', 'layout'];
    protected $casts = ['layout' => 'array'];

    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to room items
    public function items()
    {
        return $this->hasMany(RoomItem::class);
    }

    // Get all placed furniture through room items
    public function placedFurniture()
    {
        return $this->hasManyThrough(
            UserFurniture::class,
            RoomItem::class,
            'room_id',    // Foreign key on room_items table
            'id',         // Foreign key on user_furniture table
            'id',         // Local key on rooms table
            'user_furniture_id' // Local key on room_items table
        )->with('furniture');
    }

    // Helper to get all furniture items with their positions
    public function getFurnitureWithPositions()
    {
        return $this->placedFurniture->map(function ($userFurniture) {
            $roomItem = $userFurniture->roomItems->firstWhere('room_id', $this->id);

            return [
                'id' => $userFurniture->id,
                'furniture_id' => $userFurniture->furniture_id,
                'name' => $userFurniture->furniture->name,
                'image' => $userFurniture->furniture->image_path,
                'x' => $roomItem->x_position,
                'y' => $roomItem->y_position,
                'rotation' => $roomItem->rotation
            ];
        });
    }
}
