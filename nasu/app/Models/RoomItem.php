<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomItem extends Model
{

    protected $casts = [
        'furniture_id' => 'integer',
        'user_furniture_id' => 'integer',
        'x_position' => 'float',
        'y_position' => 'float',
        'rotation' => 'integer',
        'view' => 'string',
    ];
    protected $fillable = [
        'room_id',
        'user_furniture_id',
        'x_position',
        'y_position',
        'rotation',
        'view'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function userFurniture(): BelongsTo
    {
        return $this->belongsTo(UserFurniture::class, 'user_furniture_id');
    }

    public function furniture()
    {
        return $this->hasOneThrough(
            Furniture::class,
            UserFurniture::class,
            'id', // Foreign key on user_furniture table
            'id', // Foreign key on furniture table
            'user_furniture_id', // Local key on room_items table
            'furniture_id' // Local key on user_furniture table
        );
    }

    public function views()
    {
        return $this->hasMany(FurnitureView::class);
    }

    public function setRotationAttribute($value)
    {
        $this->attributes['rotation'] = $value;

        $rotation = ((int) $value) % 360;

        $this->attributes['view'] = match ($rotation) {
            0 => 'front',
            90 => 'right',
            180 => 'back',
            270 => 'left',
            default => 'front',
        };
    }


    public function updateViewForRotation(int $rotation): FurnitureView|null
    {
        $viewName = match ($rotation % 360) {
            0 => 'front',
            90 => 'right',
            180 => 'back',
            270 => 'left',
            default => 'front',
        };

        $this->view = $viewName; // guardar la vista en el modelo
        $this->rotation = $rotation; // actualizar rotación también
        $this->save(); // persistir en base de datos

        return $this->userFurniture->furniture->views->firstWhere('view', $viewName);
    }


    // Accessor for easy furniture access
    public function getFurnitureAttribute()
    {
        return $this->furniture()->first();
    }
}
