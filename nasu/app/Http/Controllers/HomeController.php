<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Cargar datos con eager loading
        $user->load([
            'room.items.furniture',
            'projects.tasks',
            'tasks.checklists'
        ]);

        // Obtener proyectos recientes (3 últimos)
        $projects = $user->projects()
            ->withCount('tasks')
            ->latest()
            ->take(3)
            ->get();

        // Obtener tareas recientes (5 últimas)
        $tasks = $user->tasks()
            ->with(['project', 'checklists'])
            ->orderBy('completed')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('dashboard', [
            'room' => $user->room()->with(['items.furniture'])->first(),
            'projects' => $projects,
            'tasks' => $tasks,
            'user' => $user
        ]);
    }
}
