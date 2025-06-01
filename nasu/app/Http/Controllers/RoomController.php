<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Furniture;
use App\Models\RoomItem;
use App\Models\UserFurniture;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function show($roomId)
    {
        $room = Room::with(['placedFurniture.furniture', 'placedFurniture.roomItems'])
            ->findOrFail($roomId);

        // Get available furniture (not already placed)
        $availableFurniture = Furniture::whereDoesntHave('userFurniture', function ($query) use ($room) {
            $query->where('user_id', $room->user_id);
        })->get();

        return view('room.show', [
            'room' => $room,
            'furnitureItems' => $room->getFurnitureWithPositions(),
            'availableFurniture' => $availableFurniture
        ]);
    }

    public function placeItem(Request $request, Room $room)
    {
        $request->validate([
            'furniture_id' => 'required|exists:furniture,id',
            'x_position' => 'required|integer',
            'y_position' => 'required|integer',
            'rotation' => 'sometimes|integer'
        ]);

        // Check if user owns this furniture
        $userFurniture = UserFurniture::firstOrCreate([
            'user_id' => auth()->id(),
            'furniture_id' => $request->furniture_id
        ], [
            'purchased_at' => now(),
            'is_placed' => true
        ]);

        // Add to room
        $roomItem = RoomItem::create([
            'room_id' => $room->id,
            'user_furniture_id' => $userFurniture->id,
            'x_position' => $request->x_position,
            'y_position' => $request->y_position,
            'rotation' => $request->rotation ?? 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Item placed successfully',
            'item' => [
                'id' => $roomItem->id,
                'name' => $userFurniture->furniture->name,
                'image' => $userFurniture->furniture->image_path,
                'x' => $roomItem->x_position,
                'y' => $roomItem->y_position,
                'rotation' => $roomItem->rotation
            ]
        ]);
    }

    public function removeItem($itemId)
    {
        RoomItem::where('id', $itemId)
            ->whereHas('room', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->delete();

        return redirect()->back()->with('success', 'Item removed successfully');
    }
}
