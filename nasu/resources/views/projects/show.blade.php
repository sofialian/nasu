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

    <div class="flex items-center justify-end mt-4 space-x-4">
        <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
            Editar Proyecto
        </a>
        
        <form id="deleteForm" action="{{ route('projects.destroy', $project) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                Eliminar Proyecto
            </button>
        </form>
    </div>

    <script>
        function confirmDelete() {
            if (confirm('¿Estás seguro de que deseas eliminar este proyecto? Esta acción no se puede deshacer.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
@endsection