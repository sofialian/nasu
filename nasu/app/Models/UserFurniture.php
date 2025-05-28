<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFurniture extends Model
{
    protected $fillable = ['user_id', 'furniture_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function furniture()
    {
        return $this->belongsTo(Furniture::class);
    }

    public function roomPlacements()
    {
        return $this->hasMany(RoomItem::class, 'user_furniture_id'); 
    }
}
