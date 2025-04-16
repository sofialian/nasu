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
        
        // Carga las relaciones directamente desde User
        $user->load([
            'room.items.furniture',  // Ahora room está en User
            'projects.tasks' => fn($query) => $query->incomplete()
        ]);

        return view('home', [
            'room' => $user->room ?? null,
            'projects' => $user->projects ?? collect(),
        ]);
    }
}