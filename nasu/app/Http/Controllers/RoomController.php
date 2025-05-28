<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\UserFurniture;
use App\Models\RoomItem;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function show(Room $room)
    {
        // Eager load room items with their furniture data
        $room->load(['items.userFurniture.furniture']);

        // Get furniture the user owns but hasn't placed in this room
        $availableFurniture = auth()->user()->ownedFurniture()
            ->whereDoesntHave('roomPlacements', function ($query) use ($room) {
                $query->where('room_id', $room->id);
            })
            ->with('furniture')
            ->get();

        return view('room.show', [
            'room' => $room,
            'availableFurniture' => $availableFurniture
        ]);
    }

    public function placeItem(Request $request, $roomId)
    {
        $request->validate([
            'user_furniture_id' => 'required|exists:user_furniture,id',
            'position_x' => 'required|integer',
            'position_y' => 'required|integer'
        ]);

        RoomItem::create([
            'room_id' => $roomId,
            'user_furniture_id' => $request->user_furniture_id,
            'position_x' => $request->position_x,
            'position_y' => $request->position_y
        ]);

        return redirect()->back()->with('success', 'Item placed successfully');
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
