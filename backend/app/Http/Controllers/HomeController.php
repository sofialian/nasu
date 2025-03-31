<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $user->load([
            'profile.room.items.furniture', 
            'profile.projects.tasks' => fn($query) => $query->incomplete()
        ]);

        return view('home', [
            'room' => $user->profile->room ?? null,
            'projects' => $user->profile->projects ?? collect(),
        ]);
    }
}