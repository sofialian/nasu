@extends('layouts.app')

@section('header', 'Crear Nueva Tarea')

@section('content')
<div class="flex-grow flex items-center justify-center h-screen flex flex-col container">
    <div class="uppercase font-title">Crear Tarea</div>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="mb-4 relative">
            <x-input-label for="title" :value="__('Título de la tarea')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div class="mb-4 relative">
            <x-input-label for="description" :value="__('Descripción')" />
            <x-textarea id="description" class="block mt-1 w-full" name="description" rows="3"></x-textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mb-4 relative">
            <x-input-label :value="__('Opciones de proyecto:')" />
            
            <div class="flex items-center mb-2">
                <input type="radio" id="no_project" name="project_option" value="none" checked class="mr-2">
                <x-input-label for="no_project" :value="__('Sin proyecto')" class="ml-2" />
            </div>

            <div class="flex items-center mb-2">
                <input type="radio" id="existing_project" name="project_option" value="existing" class="mr-2">
                <x-input-label for="existing_project" :value="__('Proyecto existente')" class="ml-2" />
            </div>

            <x-select-input id="project_id" name="project_id" class="block mt-1 w-full" disabled>
                <option value="">Seleccione un proyecto</option>
                @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->project_title }}</option>
                @endforeach
            </x-select-input>

            <div class="flex items-center mb-2 mt-4 relative">
                <input type="radio" id="new_project" name="project_option" value="new" class="mr-2">
                <x-input-label for="new_project" :value="__('Crear nuevo proyecto')" class="ml-2" />
            </div>

            <x-text-input id="new_project_name" class="block mt-2 w-full" type="text" name="new_project_name" placeholder="Nombre del nuevo proyecto" disabled />
            <x-textarea id="project_description" class="block mt-2 w-full" name="project_description" rows="2" placeholder="Descripción del proyecto" disabled></x-textarea>
        </div>

        <div class="flex items-center justify-end mt-4 relative">
            <x-primary-button type="submit">
                {{ __('Crear tarea') }}
            </x-primary-button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const noProjectRadio = document.getElementById('no_project');
        const existingProjectRadio = document.getElementById('existing_project');
        const newProjectRadio = document.getElementById('new_project');
        const projectSelect = document.getElementById('project_id');
        const newProjectName = document.getElementById('new_project_name');
        const projectDescription = document.getElementById('project_description');

        function toggleFields() {
            // Reset all fields
            projectSelect.disabled = true;
            newProjectName.disabled = true;
            projectDescription.disabled = true;
            projectSelect.required = false;
            newProjectName.required = false;

            if (existingProjectRadio.checked) {
                projectSelect.disabled = false;
                projectSelect.required = true;
            } else if (newProjectRadio.checked) {
                newProjectName.disabled = false;
                projectDescription.disabled = false;
                newProjectName.required = true;
            }
        }

        noProjectRadio.addEventListener('change', toggleFields);
        existingProjectRadio.addEventListener('change', toggleFields);
        newProjectRadio.addEventListener('change', toggleFields);

        toggleFields(); // Initialize
    });
</script>
@endpush
@endsection