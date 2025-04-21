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
        return view('tasks.create', compact('projects'));
    }

    public function store(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'title' => 'required|string|max:255',  
            'description' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'new_project' => 'nullable|string|max:255',
            'project_description' => 'nullable|string'
        ]);

        // Manejar la creación de nuevo proyecto si es necesario
        $projectId = $validated['project_id'];

        if ($request->project_option === 'new' && !empty($validated['new_project'])) {
            $project = Project::create([
                'user_id' => auth()->id(),
                'project_title' => $validated['new_project'],
                'description' => $validated['project_description'] ?? null,
                'color' => $validated['color'] ?? null,
                'completed' => false,
                'date_completed' => null
            ]);
            $projectId = $project->id;
        }

        // Crear la tarea
        $task = Task::create([
            'user_id' => auth()->id(), // Asignar usuario actual
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
}
