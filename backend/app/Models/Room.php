<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['profile_id'];

    // Relaciones
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function items()
    {
        return $this->hasMany(RoomItem::class);
    }
}