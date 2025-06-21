<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Furniture;
use App\Models\RoomItem;
use App\Models\UserFurniture;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Furniture::select('category')->distinct()->pluck('category');
        $furniture = Furniture::all()->groupBy('category');

        return view('shop.index', [
            'categories' => $categories,
            'furniture' => $furniture,
            'userBeans' => auth()->user()->balance?->beans,  

        ]);
    }

    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'furniture_id' => 'required|exists:furniture,id'
        ]);

        $user = auth()->user();
        $furniture = Furniture::findOrFail($validated['furniture_id']);

        if ($user->beans < $furniture->price) {
            return back()->with('error', 'Not enough beans!');
        }

        DB::transaction(function () use ($user, $furniture) {
            $user->decrement('beans', $furniture->price);
            $user->furniture()->attach($furniture->id);
        });

        return back()->with('success', 'Item purchased!');
    }

    public function inventory()
    {
        return view('shop.inventory', [
            'ownedItems' => auth()->user()->furniture()
                ->wherePivot('is_placed', false)
                ->get(),
            'placedItems' => auth()->user()->furniture()
                ->wherePivot('is_placed', true)
                ->get()
        ]);
    }

}
