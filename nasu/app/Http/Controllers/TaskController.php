<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    public function create()
    {
        $projects = auth()->user()->projects;
        return view('tasks.create', compact('projects'));
    }

    public function store(Request $request)
{
    // Validación de los datos
    $validatedData = $request->validate([
        'task_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'project_id' => 'nullable|exists:projects,id'
    ]);
    
    // Crear la tarea con el usuario autenticado
    $task = new Task();
    $task->task_name = $validatedData['task_name'];
    $task->description = $validatedData['description'] ?? null;
    $task->project_id = $validatedData['project_id'] ?? null;
    $task->user_id = auth()->id(); // Asignar el usuario actual
    $task->save();
    
    // Redireccionar con mensaje de éxito
    return redirect()->route('tasks.index')->with('success', 'Tarea creada exitosamente');
}
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $projects = auth()->user()->projects;
        return view('tasks.edit', compact('task', 'projects'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'task_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'nullable|exists:projects,id',
            'completed' => 'sometimes|boolean',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada correctamente');
    }
}
