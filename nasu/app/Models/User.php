<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'exp',
        'beans',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'exp' => 'integer',
            'beans' => 'integer',
        ];
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }

    //ROOM
    // 1 user HAS:
    public function balance()
    {
        return $this->hasOne(UserBalance::class); // 1:1
    }

    public function room()
    {
        return $this->hasOne(Room::class); // 1:1
    }

    // public function furniture()
    // {
    //     return $this->belongsToMany(Furniture::class, 'user_furniture')
    //         ->withPivot('is_placed')
    //         ->withTimestamps();
    // }

    public function ownedFurniture()
    {
        return $this->hasMany(UserFurniture::class);
    }

    public function hasFurniture($furnitureId)
    {
        return $this->ownedFurniture()->where('furniture_id', $furnitureId)->exists();
    }
}
