<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $user->load([
            'room.items.furniture',
            'projects.tasks' => fn($query) => $query->incomplete()
        ]);

        return view('dashboard', [
            'room' => $user->room ?? new Room(),
            'projects' => $user->projects ?? collect(),
            'user' => $user
        ]);
    }
}
