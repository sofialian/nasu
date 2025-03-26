<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'list_name',         
        'description',  
        'completed',     
    ];

    // Relaciones
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}