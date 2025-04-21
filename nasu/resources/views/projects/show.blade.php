@extends('layouts.app')
@section('header', 'Detalles del Proyecto')
@section('content')
    <div class="mb-4">
        <h2 class="text-lg font-semibold">Nombre del Proyecto</h2>
        <p>{{ $project->project_title }}</p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Descripción</h2>
        <p>{{ $project->description }}</p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Fecha de Creación</h2>
        <p>{{ $project->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Última Actualización</h2>
        <p>{{ $project->updated_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="flex items-center justify-end mt-4">
        <a href="{{ route('projects.edit', $project) }}" class="text-blue-500 hover:text-blue-700">Editar Proyecto</a>
    </div>
@endsection