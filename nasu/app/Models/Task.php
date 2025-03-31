<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'task_name',           
        'description',    
        'completed',      
        'completed_at',   
    ];

    // Relaciones
    /*
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function checklists()
    {
        return $this->hasMany(Checklist::class); // Antes 'listas'
    }
        */
}