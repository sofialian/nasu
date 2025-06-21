<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Furniture;
use App\Models\RoomItem;
use App\Models\UserFurniture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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

    public function edit(Room $room)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Ensure the room belongs to the current user
        if ($room->user_id !== auth()->id()) {
            abort(403);
        }

        // Get furniture already in the room
        $roomItems = $room->items()->with(['furniture', 'userFurniture'])->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'x' => $item->x_position,
                'y' => $item->y_position,
                'rotation' => $item->rotation,
                'name' => $item->furniture->name,
                'image' => $item->furniture->image_path,
                'furniture_id' => $item->furniture_id,
                'user_furniture_id' => $item->user_furniture_id,
            ];
        });

        // Get user's furniture NOT in this room
        $availableFurniture = auth()->user()->ownedFurniture()
            ->with('furniture')
            ->whereDoesntHave('roomItems', function ($query) use ($room) {
                $query->where('room_id', $room->id);
            })
            ->get()
            ->map(function ($userFurniture) {
                return [
                    'furniture_id' => $userFurniture->furniture_id,
                    'user_furniture_id' => $userFurniture->id,
                    'name' => $userFurniture->furniture->name,
                    'image' => $userFurniture->furniture->image_path,
                ];
            });

        return view('room.edit', [
            'room' => $room,
            'furnitureItems' => $roomItems,
            'availableFurniture' => $availableFurniture,
        ]);
    }

    public function updateItems(Request $request, Room $room)
    {
        $validated = $request->validate([
            'items' => 'array',
            'items.*.id' => 'required|integer',
            'items.*.x' => 'required|numeric|between:0,100',
            'items.*.y' => 'required|numeric|between:0,100',
            'items.*.rotation' => 'required|integer',
            'new_items' => 'array',
            'new_items.*.furniture_id' => 'required|integer',
            'new_items.*.user_furniture_id' => 'required|integer',
            'new_items.*.x' => 'required|integer',
            'new_items.*.y' => 'required|integer',
            'new_items.*.rotation' => 'required|integer',
            'removed_items' => 'array',
            'removed_items.*' => 'integer',
        ]);

        DB::transaction(function () use ($room, $validated) {
            // Update existing items
            foreach ($validated['items'] ?? [] as $itemData) {
                $room->items()->where('id', $itemData['id'])->update([
                    'x_position' => $itemData['x'],
                    'y_position' => $itemData['y'],
                    'rotation' => $itemData['rotation'],
                ]);
            }

            // Add new items
            foreach ($validated['new_items'] ?? [] as $newItem) {
                $room->items()->create([
                    'furniture_id' => $newItem['furniture_id'],
                    'user_furniture_id' => $newItem['user_furniture_id'],
                    'x_position' => $itemData['x'],  // Changed from x to x_position
                    'y_position' => $itemData['y'],  // Changed from y to y_position
                    'rotation' => $itemData['rotation'],
                ]);
            }

            // Remove items
            if (!empty($validated['removed_items'])) {
                $room->items()->whereIn('id', $validated['removed_items'])->delete();
            }
        });

        return response()->json([
            'success' => true,
            'redirect' => route('dashboard', $room),
        ]);
    }
}
