<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Furniture;
use App\Models\Room;
use App\Models\RoomItem;
use App\Models\UserBalance;
use App\Models\User;
use App\Models\UserFurniture;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'email_confirmation' => ['required', 'email', 'same:email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();

        try {
            // 1. Create the new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 2. Create user's starting balance
            UserBalance::create([
                'user_id' => $user->id,
                'beans' => 1000,
            ]);

            // 3. Get all default furniture items
            $defaultFurniture = Furniture::where('is_default', true)->get();

            if ($defaultFurniture->isEmpty()) {
                Log::warning('No default furniture found for new user', ['user_id' => $user->id]);
            }

            // 4. Create the user's starter room
            $room = Room::create([
                'user_id' => $user->id,
                'name' => 'Mi Primera Habitación',
                'theme' => 'default',
                'layout' => ['items' => []]
            ]);

            // 5. Split default furniture into items for room and inventory
            $itemsForRoom = $defaultFurniture->take(2); // First 2 items go in room
            $itemsForInventory = $defaultFurniture->slice(2); // Rest go to inventory

            $layoutItems = [];

            // 6. Add items to be placed in the room
            foreach ($itemsForRoom as $furniture) {
                $userFurniture = UserFurniture::create([
                    'user_id' => $user->id,
                    'furniture_id' => $furniture->id,
                    'purchased_at' => now()
                ]);

                // Add to room with default positions
                $roomItem = RoomItem::create([
                    'room_id' => $room->id,
                    'user_furniture_id' => $userFurniture->id,
                    'x_position' => $furniture->default_x ?? 100,
                    'y_position' => $furniture->default_y ?? 100,
                    'rotation' => 0
                ]);

                // Prepare layout data
                $layoutItems[] = [
                    'id' => $roomItem->id,
                    'furniture_id' => $furniture->id,
                    'user_furniture_id' => $userFurniture->id,
                    'name' => $furniture->name,
                    'image' => $furniture->image_path,
                    'x' => $roomItem->x_position,
                    'y' => $roomItem->y_position,
                    'rotation' => $roomItem->rotation,
                    'placed_at' => now()->toDateTimeString()
                ];
            }

            // 7. Add remaining items to inventory (not placed in room)
            foreach ($itemsForInventory as $furniture) {
                UserFurniture::create([
                    'user_id' => $user->id,
                    'furniture_id' => $furniture->id,
                    'purchased_at' => now()
                ]);
            }

            // 8. Update the room layout with only the placed items
            $room->update([
                'layout' => ['items' => $layoutItems]
            ]);

            DB::commit();

            // Complete registration
            event(new Registered($user));
            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User registration failed: ' . $e->getMessage());
            throw $e;
        }
    }
}