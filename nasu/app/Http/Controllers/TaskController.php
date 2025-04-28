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

    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'project_option' => 'sometimes|string', // Cambiado a "sometimes"
            'new_project' => 'required_if:project_option,new|string|max:255',
            'project_description' => 'nullable|string',
        ]);
    
        $projectId = $validated['project_id'] ?? null;
    
        // Verifica explícitamente si el radio está seleccionado
        if ($request->filled('project_option') && $request->project_option === 'new') {
            $project = Project::create([
                'user_id' => auth()->id(),
                'project_title' => $validated['new_project'],
                'description' => $validated['project_description'] ?? null,
                'color' => 'blue', // Valor por defecto
                'completed' => false
            ]);
            $projectId = $project->id;
        }

        // Crear la tarea
        $task = Task::create([
            'user_id' => auth()->id(),
            'project_id' => $projectId,
            'task_title' => $validated['title'],
            'description' => $validated['description'],
            'completed' => false
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarea'. $projectId .'creada correctamente');
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
