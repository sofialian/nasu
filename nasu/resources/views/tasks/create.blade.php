@extends('layouts.app')

@section('header', 'Crear Nueva Tarea')

@section('content')
<div class="flex-grow flex items-center justify-center mt-8 flex flex-col container">
    <div class="w-full max-w-4xl pt-0 text-primary-dark text-base">
        <div class="uppercase font-title text-xl text-center mb-6">Crear Tarea</div>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="md:flex md:space-x-6">
                <!-- Left Column -->
                <div class="md:w-1/2 md:px-8">
                    <div class="mb-4 relative">
                        <x-text-input
                            id="title"
                            class="block w-full"
                            type="text"
                            name="title"
                            required
                            placeholder=" " />
                        <x-input-label for="title" :value="__('Título de la tarea')" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mb-4 relative py-8">
                        <x-textarea
                            id="description"
                            class="block mt-5 w-full"
                            name="description"
                            rows="3"
                            placeholder=" "></x-textarea>
                        <x-input-label for="description" :value="__('Descripción')" class="" />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        <div class="flex items-center mt-4">
                            <input type="radio" id="no_project" name="project_option" value="none" checked class="mr-2">
                            <!-- <x-input-label for="no_project" :value="__('Sin proyecto')" class="ml-2" /> -->
                            <label for="no_project" class="font-body font-medium">Sin proyecto</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="existing_project" name="project_option" value="existing" class="mr-2">
                            <!-- <label for="existing_project" :value="__('Proyecto existente')" class="ml-2" /> -->
                            <label for="existing_project" class="font-body font-medium">Proyecto existente</label>
                        </div>
                        <x-select-input
                            id="project_id"
                            name="project_id"
                            class="block mt-1 w-full"
                            disabled>
                            <option value="" class="">Selecciona un proyecto</option>
                            @foreach($projects as $project)
                            <option value="{{ $project->id }}" class="text-base">{{ $project->project_title }}</option>
                            @endforeach
                        </x-select-input>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="md:w-1/2 md:px-8">
                    <div class="mb-4 relative">
                        <div class="space-y-3">

                            <div class="flex items-center pt-2">
                                <input type="radio" id="new_project" name="project_option" value="new" class="mr-2">
                                <!-- <label for="new_project" :value="__('Crear nuevo proyecto')" class="ml-2 border-2 border-fuchsia-500" /> -->
                                <label for="new_project" class="font-body font-medium">Crear nuevo proyecto</label>
                            </div>

                            <x-text-input
                                id="new_project_name"
                                class="block mt-2 w-full"
                                type="text"
                                name="new_project_name"
                                placeholder="Nombre del nuevo proyecto"
                                disabled />

                            <x-textarea
                                id="project_description"
                                class="block w-full"
                                name="project_description"
                                rows="2"
                                placeholder="Descripción"
                                disabled></x-textarea>
                            <div class="mb-4">
                                <label for="color_project" class="font-body font-medium">Color</label>
                                <select id="color_project" name="color_project" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" disabled>
                                    @foreach($colors as $value => $label)
                                    <option value="{{ $value }}" class="text-{{ $value }}-500">
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-6">
                <x-primary-button type="submit" class="w-1/2 md:w-auto px-8">
                    {{ __('Crear tarea') }}
                </x-primary-button>
            </div>
        </form>
    </div>
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
        const projectColor = document.getElementById('color_project');

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
                projectColor.disabled = false;
                newProjectName.required = true;
            }
        }

        noProjectRadio.addEventListener('change', toggleFields);
        existingProjectRadio.addEventListener('change', toggleFields);
        newProjectRadio.addEventListener('change', toggleFields);
        projectColor.addEventListener('change', toggleFields);


        toggleFields(); // Initialize
    });
</script>
@endpush
@endsection