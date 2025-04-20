<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'task_title',
        'description',
        'completed',
        'date_completed'
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el proyecto (si ya no la tienes)
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function checklists()
{
    return $this->hasMany(Checklist::class);
}
}