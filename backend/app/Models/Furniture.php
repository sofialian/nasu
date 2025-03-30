<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Furniture extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',           
        'description',    
        'price_beans',    
        'image_url',
    ];

    // Relación con la habitación
    public function roomItems()
    {
        return $this->hasMany(Room::class);
    }
}