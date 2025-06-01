<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Furniture;

class FurnitureController extends Controller
{
    // app/Http/Controllers/FurnitureController.php
    public function index()
    {
        $furniture = Furniture::where('is_purchasable', true)->get();
        $userFurniture = auth()->user()->ownedFurniture()->with('furniture')->get();

        return view('furniture.index', compact('furniture', 'userFurniture'));
    }
}
