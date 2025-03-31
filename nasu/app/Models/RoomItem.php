<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomItem extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 
    'furniture_id', 
    'posx', 
    'posy', 
    'rotation'];

    // Relaciones
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function furniture()
    {
        return $this->belongsTo(Furniture::class);
    }
}
