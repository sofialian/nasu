<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'project_id',
        'task_id',
        'completed_at',      // Antes 'fecha_completado'
        'gained_exp', // Antes 'experiencia_ganada'
        'gained_beans',      // Antes 'monedas_ganadas'
    ];

    // Relaciones
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}