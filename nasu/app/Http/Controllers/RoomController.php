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
        // Eager load the necessary relationships
        $room->load(['items.furniture', 'items.userFurniture']);

        // Prepare furniture items with their positions
        $furnitureItems = $room->items->map(function ($item) {
            return [
                'id' => $item->id,
                'furniture_id' => $item->furniture->id,
                'user_furniture_id' => $item->user_furniture_id,
                'name' => $item->furniture->name,
                'image' => $item->furniture->image_path,
                'x' => $item->x_position,
                'y' => $item->y_position,
                'rotation' => $item->rotation
            ];
        });

        // Get available furniture (not placed in this room)
        $availableFurniture = UserFurniture::with('furniture')
            ->where('user_id', auth()->id())
            ->whereDoesntHave('roomItems', function ($query) use ($room) {
                $query->where('room_id', $room->id);
            })
            ->get()
            ->map(function ($userFurniture) {
                return [
                    'furniture_id' => $userFurniture->furniture->id,
                    'user_furniture_id' => $userFurniture->id,
                    'name' => $userFurniture->furniture->name,
                    'image' => $userFurniture->furniture->image_path
                ];
            });

        return view('room.edit', [
            'room' => $room,
            'furnitureItems' => $furnitureItems,
            'availableFurniture' => $availableFurniture
        ]);
    }

    public function updateItems(Request $request, Room $room)
    {
        \Log::info('Update items request:', $request->all());

        $validator = Validator::make($request->all(), [
            'items' => 'sometimes|array',
            'items.*.id' => 'required_with:items|exists:room_items,id',
            'items.*.x' => 'required_with:items|integer',
            'items.*.y' => 'required_with:items|integer',
            'items.*.rotation' => 'required_with:items|integer|in:0,90,180,270',
            'new_items' => 'sometimes|array',
            'new_items.*.furniture_id' => 'required_with:new_items|exists:furniture,id',
            'new_items.*.user_furniture_id' => 'required_with:new_items|exists:user_furniture,id',
            'new_items.*.x' => 'required_with:new_items|integer',
            'new_items.*.y' => 'required_with:new_items|integer',
            'new_items.*.rotation' => 'required_with:new_items|integer|in:0,90,180,270',
            'removed_items' => 'sometimes|array',
            'removed_items.*' => 'required_with:removed_items|exists:room_items,id'
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Update existing items
            if ($request->has('items')) {
                foreach ($request->items as $item) {
                    $roomItem = RoomItem::find($item['id']);

                    if (!$roomItem) {
                        throw new \Exception("Item not found: " . $item['id']);
                    }

                    $roomItem->update([
                        'x_position' => $item['x'],
                        'y_position' => $item['y'],
                        'rotation' => $item['rotation']
                    ]);
                }
            }

            // Add new items
            if ($request->has('new_items')) {
                foreach ($request->new_items as $item) {
                    $newItem = RoomItem::create([
                        'room_id' => $room->id,
                        'user_furniture_id' => $item['user_furniture_id'],
                        'x_position' => $item['x'],
                        'y_position' => $item['y'],
                        'rotation' => $item['rotation']
                    ]);
                    \Log::info("Created new item", $newItem->toArray());
                }
            }

            // Remove deleted items
            if ($request->has('removed_items')) {
                $deleted = RoomItem::whereIn('id', $request->removed_items)->delete();
                \Log::info("Deleted items count: " . $deleted);
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
            \Log::error("Stack trace: " . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save changes: ' . $e->getMessage()
            ], 500);
        }
    }
}
