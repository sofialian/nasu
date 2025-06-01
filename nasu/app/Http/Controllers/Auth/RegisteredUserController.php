<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Furniture;
use App\Models\Room;
use App\Models\UserBalance;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
    // app/Http/Controllers/Auth/RegisteredUserController.php
    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            // 1. Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 2. Give starting beans
            UserBalance::create([
                'user_id' => $user->id,
                'beans' => 1000,
            ]);

            // 3. Get DEFAULT (free) furniture (not purchasable shop items)
            $defaultFurniture = Furniture::where('is_default', true)->get();

            // 4. Create empty room
            $room = Room::create([
                'user_id' => $user->id,
                'name' => 'Mi Primera Habitación'
            ]);

            // 5. Add default furniture to user's collection and room
            foreach ($defaultFurniture as $furniture) {
                // Add to user's owned furniture
                $userFurniture = $user->furniture()->create([
                    'furniture_id' => $furniture->id,
                    'purchased_at' => now(),
                    'is_placed' => true
                ]);

                // Add to room
                $room->items()->create([
                    'user_furniture_id' => $userFurniture->id,
                    'x_position' => 0,
                    'y_position' => 0,
                    'rotation' => 0
                ]);
            }

            DB::commit();

            event(new Registered($user));
            Auth::login($user);
            return redirect(route('dashboard'));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
