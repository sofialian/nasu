<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_title', 
        'description',
        'color',
        'completed'
    ];

    public static $colors = [
        'red' => 'Rojo',
        'blue' => 'Azul',
        'green' => 'Verde',
        'yellow' => 'Amarillo',
        'indigo' => 'Indigo',
        'purple' => 'Morado',
        'pink' => 'Rosa'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}