<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Redirigir si no está autenticado
        if (!$user) {
            return redirect()->route('login');
        }

        // Cargar todas las relaciones necesarias
        $user->load([
            'room.items.furniture',
            'projects.tasks',
            'tasks.checklists'
        ]);

        // Obtener datos específicos
        $recentTasks = $user->tasks()
            ->with(['project', 'checklists'])
            ->orderBy('completed')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $projectsWithCount = $user->projects()
            ->withCount('tasks')
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard', [
            'room' => $user->room ?? new Room(),
            'projects' => $projectsWithCount,
            'tasks' => $recentTasks,
            'user' => $user
        ]);
    }
}