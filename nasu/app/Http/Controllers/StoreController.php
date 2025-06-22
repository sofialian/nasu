<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Furniture;
use App\Models\RoomItem;
use App\Models\UserFurniture;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $categories = Furniture::select('category')->distinct()->pluck('category');
        $furniture = Furniture::all()->groupBy('category');

        // Obtener IDs de los muebles que el usuario ya posee
        $ownedFurnitureIds = $user->furniture()->pluck('furniture.id')->toArray();

        return view('store.index', [
            'categories' => $categories,
            'furniture' => $furniture,
            'userBeans' => $user->balance?->beans,
            'ownedFurnitureIds' => $ownedFurnitureIds
        ]);
    }


    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'furniture_id' => 'required|exists:furniture,id'
        ]);

        $user = auth()->user();
        $furniture = Furniture::findOrFail($validated['furniture_id']);

        // Verifica si el usuario ya posee este mueble
        if ($user->furniture()->where('furniture.id', $furniture->id)->exists()) {
            return back()->with('info', 'Ya tienes este mueble.');
        }

        // Verifica si el mueble es comprable
        if (!$furniture->is_purchasable) {
            return back()->with('error', 'Este mueble no está disponible para la compra.');
        }

        // Verifica si el usuario tiene suficientes beans
        $userBeans = $user->balance->beans ?? 0;

        if ($userBeans < $furniture->price) {
            return back()->with('error', '¡No tienes suficientes beans!');
        }

        // Transacción: descontar y asignar el mueble
        DB::transaction(function () use ($user, $furniture) {
            $user->balance->decrement('beans', $furniture->price);
            $user->furniture()->attach($furniture->id);
            $user->furniture()->attach($furniture->id, ['purchased_at' => now()]);
        });

        return back()->with('success', '¡Has comprado "' . $furniture->name . '" con éxito!');
    }


    public function inventory()
    {
        return view('store.inventory', [
            'ownedItems' => auth()->user()->furniture()
                ->wherePivot('is_placed', false)
                ->get(),
            'placedItems' => auth()->user()->furniture()
                ->wherePivot('is_placed', true)
                ->get()
        ]);
    }
}
