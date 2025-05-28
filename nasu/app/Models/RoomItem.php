<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomItem extends Model
{
    protected $fillable = ['room_id', 'user_furniture_id', 'position_x', 'position_y'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function userFurniture()
    {
        return $this->belongsTo(UserFurniture::class);
    }
}
