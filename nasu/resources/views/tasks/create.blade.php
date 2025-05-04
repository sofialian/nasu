@extends('layouts.app')

@section('header', 'Crear Nueva Tarea')

@section('content')
<div class="flex-grow flex items-center justify-center h-screen flex flex-col">
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <x-input-label for="title" :value="__('Título de la tarea')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="description" :value="__('Descripción')" />
            <x-textarea id="description" class="block mt-1 w-full" name="description" rows="3" />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label :value="__('Asociar a proyecto:')" />

            <div class="flex items-center mb-2">
                <x-radio-input id="existing_project" name="project_option" value="existing" checked />
                <x-input-label for="existing_project" :value="__('Proyecto existente')" class="ml-2" />
            </div>

            <x-select-input id="project_id" name="project_id" class="block mt-1 w-full">
                <option value="">Sin proyecto</option>
                @foreach($projects as $project)
                <option value="{{ $project->id }}">{{ $project->project_title }}</option>
                @endforeach
            </x-select-input>
        </div>

        <div class="mb-4">
            <div class="flex items-center mb-2">
                <x-radio-input id="new_project" name="project_option" value="new" />
                <x-input-label for="new_project" :value="__('Crear nuevo proyecto')" class="ml-2" />
            </div>

            <x-text-input id="new_project_name" class="block mt-2 w-full" type="text" name="new_project_name" placeholder="Nombre del nuevo proyecto" disabled />
            <x-textarea id="project_description" class="block mt-2 w-full" name="project_description" rows="2" placeholder="Descripción del proyecto" disabled />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button type="submit">
                {{ __('Crear tarea') }}
            </x-primary-button>
        </div>
    </form>

    @push('scripts')
    <script>
        alert('¡Bienvenido a la creación de tareas!.');
        document.addEventListener('DOMContentLoaded', function() {
            const existingProjectRadio = document.getElementById('existing_project');
            const newProjectRadio = document.getElementById('new_project');
            const projectSelect = document.getElementById('project_id');
            const newProjectName = document.getElementById('new_project_name');
            const projectDescription = document.getElementById('project_description');

            function toggleFields() {
                if (existingProjectRadio.checked) {
                    projectSelect.disabled = false;
                    newProjectName.disabled = true;
                    projectDescription.disabled = true;
                } else {
                    projectSelect.disabled = true;
                    newProjectName.disabled = false;
                    projectDescription.disabled = false;
                }
            }

            existingProjectRadio.addEventListener('change', toggleFields);
            newProjectRadio.addEventListener('change', toggleFields);

            // Initialize
            toggleFields();
        });
    </script>
    @endpush
</div>
@endsection