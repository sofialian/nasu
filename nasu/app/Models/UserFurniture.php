<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFurniture extends Model
{
    protected $fillable = [
        'user_id',
        'furniture_id',
        'purchased_at',
        'is_placed'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function furniture(): BelongsTo
    {
        return $this->belongsTo(Furniture::class);
    }

    public function roomItems()
    {
        return $this->hasMany(RoomItem::class, 'user_furniture_id');
    }
}