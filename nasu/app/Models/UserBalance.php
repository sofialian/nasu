<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    protected $fillable = [
        'user_id',
        'beans'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
