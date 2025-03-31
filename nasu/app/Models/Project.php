<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'project_name',         
        'description', 
        'completed',  
        'completed_at',  
    ];

    // Relaciones
    /*
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
        */
}