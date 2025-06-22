<?php
use Illuminate\Support\Facades\Route;
use App\Models\Furniture;

Route::get('/furniture/{id}/view', function($id) {
    $rotation = request('rotation', 0);
    $furniture = Furniture::findOrFail($id);
    $view = $furniture->viewForRotation($rotation);
    
    return response()->json($view);
});