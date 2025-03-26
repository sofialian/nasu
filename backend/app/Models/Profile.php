<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles'; // Opcional si sigues convención de nombres (Profile → 'profiles')

    protected $fillable = [
        'username',       
        'email',          
        'password', 
        'exp',   
        'beans',  
    ];

    // Relaciones
    /*
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function roomItems()
    {
        return $this->hasMany(RoomItem::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }
        */
}