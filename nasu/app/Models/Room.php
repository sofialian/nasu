<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['user_id', 'theme', 'layout'];

    // Cast JSON fields to arrays
    protected $casts = [
        'layout' => 'array',
    ];

    // Room belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
