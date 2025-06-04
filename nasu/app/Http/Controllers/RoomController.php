<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Furniture;
use App\Models\RoomItem;
use App\Models\UserFurniture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Add this import
use Illuminate\Support\Facades\DB; // Add this import

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

    // app/Http/Controllers/RoomController.php
public function edit(Room $room)
{
    $room->load(['placedFurniture.furniture', 'placedFurniture.roomItems']);

    // Get user's furniture NOT currently in this room
    $availableFurniture = UserFurniture::with('furniture')
        ->where('user_id', auth()->id())
        ->whereDoesntHave('roomItems', function($query) use ($room) {
            $query->where('room_id', $room->id);
        })
        ->get();

    return view('room.edit', [
        'room' => $room,
        'furnitureItems' => $room->getFurnitureWithPositions(),
        'availableFurniture' => $availableFurniture->map(function($userFurniture) {
            return [
                'id' => $userFurniture->id,
                'furniture_id' => $userFurniture->furniture_id,
                'name' => $userFurniture->furniture->name,
                'image' => $userFurniture->furniture->image_path
            ];
        })
    ]);
}

    // app/Http/Controllers/RoomController.php
public function updateItems(Request $request, Room $room)
{
    \Log::debug('Update Request:', $request->all());
    
    $validated = $request->validate([
        'items' => 'required|json',
        'removed_items' => 'sometimes|json'
    ]);

    // Decode the JSON data
    $items = json_decode($request->items, true);
    $removedItems = json_decode($request->removed_items ?? '[]', true);

    // Additional validation
    $validator = Validator::make(['items' => $items, 'removed_items' => $removedItems], [
        'items.*.id' => 'required|exists:room_items,id',
        'items.*.x' => 'required|integer|min:0',
        'items.*.y' => 'required|integer|min:0',
        'items.*.rotation' => 'required|integer|in:0,90,180,270',
        'removed_items.*' => 'exists:room_items,id'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    DB::beginTransaction();
    try {
        // Update positions and rotations
        foreach ($items as $item) {
            RoomItem::where('id', $item['id'])
                   ->where('room_id', $room->id)
                   ->update([
                       'x_position' => $item['x'],
                       'y_position' => $item['y'],
                       'rotation' => $item['rotation']
                   ]);
        }

        // Remove deleted items
        if (!empty($removedItems)) {
            RoomItem::whereIn('id', $removedItems)
                   ->where('room_id', $room->id)
                   ->delete();
        }

        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => 'Room updated successfully!',
            'redirect' => route('room.show', $room)
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error("Update failed: " . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to save changes: ' . $e->getMessage()
        ], 500);
    }
}
}
