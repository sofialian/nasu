<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'furniture_id',
        'pos_x',   
        'pos_y',   
    ];

    // Relaciones
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function furniture()
    {
        return $this->belongsTo(Furniture::class);
    }
}