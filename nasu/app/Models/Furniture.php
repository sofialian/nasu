<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Furniture extends Model
{
    use HasFactory;

    protected $fillable = ['furniture_name',
    'category', 
    'description', 
    'price_beans', 
    'image_url'];

    // Relación con room_items
    public function roomItems()
    {
        return $this->hasMany(RoomItem::class);
    }
}