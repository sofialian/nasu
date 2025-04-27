<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects()
            ->withCount('tasks')
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create', [
            'colors' => Project::$colors
        ]);
    }

    public function store(Request $request)
    {
        // Verificar autenticación primero
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para crear proyectos');
        }

        // Validación
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|in:' . implode(',', array_keys(Project::$colors))
        ]);

        try {
            // Crear proyecto usando la relación del usuario
            $project = auth()->user()->projects()->create([
                'project_title' => $validated['title'],
                'description' => $validated['description'],
                'color' => $validated['color'],
                'completed' => false
            ]);


            return redirect()->route('projects.index')
                ->with('success', "Proyecto {$project->project_title} creado correctamente");
                
        } catch (\Exception $e) {
            \Log::error('Error al crear proyecto:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withInput()
                ->with('error', 'Error al crear el proyecto: ' . $e->getMessage());
        }
    }

    public function edit(Project $project)
    {
        if (auth()->id() !== $project->user_id) {
            abort(403, 'No autorizado');
        }
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        // Verificación de autorización mejorada
        if (auth()->id() !== $project->user_id) {
            return back()->with('error', 'No tienes permisos para editar este proyecto');
        }

        // Validación robusta
        $validated = $request->validate([
            'project_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|in:red,blue,green,yellow,indigo,purple,pink'
        ]);

        // Debugging
        \Log::debug('Actualizando proyecto', [
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'data' => $validated
        ]);

        try {
            $project->update($validated);

            return redirect()->route('projects.index')
                ->with('success', 'Proyecto actualizado correctamente');
        } catch (\Exception $e) {
            \Log::error('Error al actualizar proyecto', [
                'error' => $e->getMessage(),
                'project' => $project->id
            ]);

            return back()->withInput()
                ->with('error', 'Error al actualizar el proyecto');
        }
    }

    public function show(Project $project)
    {

        $project->load(['tasks' => function ($query) {
            $query->with('checklists')->latest();
        }]);

        return view('projects.show', compact('project'));
    }

    public function destroy(Project $project)
    {
        // Verificación de autorización
        if (auth()->id() !== $project->user_id) {
            return back()->with('error', 'No autorizado');
        }

        // Eliminar el proyecto
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Proyecto eliminado correctamente');
    }
    public function complete(Project $project)
    {
        // Verificación de autorización
        if (auth()->id() !== $project->user_id) {
            return back()->with('error', 'No autorizado');
        }

        // Completar el proyecto
        $project->update([
            'completed' => true,
            'date_completed' => now()
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Proyecto completado correctamente');
    }
}
