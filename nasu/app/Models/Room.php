<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['user_id', 'theme', 'layout'];

    protected $casts = [
        'layout' => 'array'
    ];

    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getItemsAttribute()
    {
        return $this->layout['items'] ?? [];
    }

    public function addItem($furnitureId, $x = 0, $y = 0)
    {
        $furniture = Furniture::findOrFail($furnitureId);

        $items = $this->items;
        $items[] = [
            'id' => $furniture->id,
            'name' => $furniture->name,
            'image' => $furniture->image_path,
            'x' => $x,
            'y' => $y,
            'placed_at' => now()->toDateTimeString()
        ];

        $this->layout = ['items' => $items];
        $this->save();

        return $this;
    }

    public function removeItem($index)
    {
        $items = $this->items;
        if (isset($items[$index])) {
            unset($items[$index]);
            $this->layout = ['items' => array_values($items)]; // Reindex array
            $this->save();
        }
        return $this;
    }

    public function items()
    {
        return $this->hasMany(RoomItem::class);
    }

    // Other relationships you might have
    public function furniture()
    {
        return $this->hasMany(Furniture::class);
    }


    public function deployedFurniture()
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
}
