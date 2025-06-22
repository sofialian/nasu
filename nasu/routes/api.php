<?php

use Illuminate\Support\Facades\Route;
use App\Models\Furniture;
use App\Models\RoomItem;


Route::get('/room-item/{id}/image/{rotation}', function ($id, $rotation) {
    $item = RoomItem::findOrFail($id);

    $view = $item->updateViewForRotation((int)$rotation);

    return response()->json([
        'image_url' => asset($view?->image_path ?? 'furniture/default.png'),
    ]);
});
