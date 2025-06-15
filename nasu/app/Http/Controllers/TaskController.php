<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks()
            ->with(['project', 'checklists'])
            // ->orderBy('completed')
            ->orderByDesc('created_at')
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tarea eliminada correctamente');
    }
    public function create()
    {
        $projects = auth()->user()->projects;
        $colors = Project::$colors;
        return view('tasks.create', compact('projects', 'colors'));
    }

    public function store(Request $request)
    {
        // Validación básica para todos los casos
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_option' => 'required|in:none,existing,new',
        ]);

        // Manejo de proyectos según la opción seleccionada
        $projectId = null;

        switch ($request->project_option) {
            case 'existing':
                $request->validate([
                    'project_id' => 'required|exists:projects,id',
                ]);
                $projectId = $request->project_id;
                break;

            case 'new':
                $request->validate([
                    'new_project_name' => 'required|string|max:255',
                    'project_description' => 'nullable|string',
                ]);

                $project = Project::create([
                    'user_id' => auth()->id(),
                    'project_title' => $request->new_project_name,
                    'description' => $request->project_description,
                    'color' => 'blue',
                    'completed' => false
                ]);

                $projectId = $project->id;
                break;

            case 'none':
            default:
                // No se asocia a ningún proyecto
                $projectId = null;
                break;
        }

        // Crear la tarea
        Task::create([
            'user_id' => auth()->id(),
            'project_id' => $projectId,
            'task_title' => $validated['title'],
            'description' => $validated['description'],
            'completed' => false
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarea creada correctamente');
    }

    public function edit(Task $task)
    {
        $projects = auth()->user()->projects;
        return view('tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        // Verificación de autorización (opción manual)
        if (auth()->id() !== $task->user_id) {
            return back()->with('error', 'No autorizado');
        }

        $validated = $request->validate([
            'task_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'completed' => 'sometimes|boolean',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea actualizada correctamente');
    }

    public function toggle(Task $task)
    {
        // Verificar autorización
        if (auth()->id() !== $task->user_id) {
            abort(403);
        }

        $task->update(['completed' => !$task->completed]);

        return back()->with('success', 'Estado de la tarea actualizado');
    }
}
