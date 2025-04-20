<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;

class ProjectController extends Controller
{
    public function create()
    {
        return view('projects.create', [
            'colors' => Project::$colors
        ]);
    }
    
    public function store(Request $request)
    {
        // Validación
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|in:' . implode(',', array_keys(Project::$colors))
        ]);

        // Crear proyecto asociado al usuario
        $project = Project::create([
            'user_id' => auth()->id(),
            'project_title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'color' => $validated['color'],
            'completed' => false,
            'date_completed' => null
            
        ]);

        // Redirigir al dashboard con mensaje
        return redirect()->route('dashboard')
               ->with('success', "Proyecto {$project->title} creado correctamente");
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.show', $project)->with('success', 'Proyecto actualizado correctamente');
    }
}


