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
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Give them 100 beans
        UserBalance::create([
            'user_id' => $user->id,
            'beans' => 100,
        ]);

        // Create their room with default items
        $defaultFurniture = Furniture::where('is_default', true)->get(); // Add this column to furniture table
        $room = Room::create([
            'user_id' => $user->id,
            'layout' => [
                'items' => $defaultFurniture->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'x' => 0, // Default position
                        'y' => 0,
                    ];
                })->toArray()
            ],
        ]);

        // Add default items to their inventory
        $user->furniture()->attach($defaultFurniture->pluck('id'), [
            'is_placed' => true
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
