<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FurnitureView extends Model
{
    public function furniture()
    {
        return $this->belongsTo(Furniture::class);
    }

    public function viewForRotation($rotation)
    {
        return $this->views()
            ->where('rotation', $rotation % 360)
            ->first();
    }
}
