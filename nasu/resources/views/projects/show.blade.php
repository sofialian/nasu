@extends('layouts.app')

@section('header', 'Detalles del Proyecto')

@section('content')
<div class="flex-grow flex items-center justify-center mt-8 flex flex-col container">
    <div class="w-full max-w-4xl p-4 rounded-lg shadow page">
        <h1 class="font-title text-center mb-4">Detalles</h1>

        <div class="space-y-4 md:px-20">
            <!-- Project Title -->
            <div class="mb-4">
                <label class="block font-medium text-sm text-primary-dark font-body mb-2">Nombre</label>
                <div class="block w-full p-3 border-b-2 border-secondary-color">
                    {{ $project->project_title }}
                </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block font-medium text-sm text-primary-dark font-body mb-2">Descripción</label>
                <div class="block w-full p-3 border-2 border-secondary-color min-h-[100px]">
                    {{ $project->description ?? 'Sin descripción' }}
                </div>
            </div>

            <!-- Color -->
            <div class="mb-4">
                <label class="block font-medium text-sm text-primary-dark font-body mb-2">Color</label>
                <div class="flex items-center">
                    <div class="w-4 h-4 rounded-full mr-2 bg-{{ $project->color }}-500"></div>
                    <span class="capitalize">{{ $project->color }}</span>
                </div>
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block font-medium text-sm text-primary-dark font-body mb-2">Fecha de Creación</label>
                    <div class="text-gray-600">
                        {{ $project->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block font-medium text-sm text-primary-dark font-body mb-2">Última Actualización</label>
                    <div class="text-gray-600">
                        {{ $project->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-center items-center mt-8 space-x-4">
                <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                    Editar
                </a>

                <form id="deleteForm" action="{{ route('projects.destroy', $project) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        if (confirm('¿Estás seguro de que deseas eliminar este proyecto? Esta acción no se puede deshacer.')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endsection