@extends('layouts.app')

@section('header', 'Editar Proyecto')

@section('content')
<div class="flex-grow flex items-center justify-center mt-8 flex-col container">
    <div class="w-full max-w-4xl pt-0 text-primary-dark text-base page">
        <div class="uppercase font-title text-xl text-center mb-6">Editar Proyecto</div>
        <form action="{{ route('projects.update', $project) }}" method="POST" class="p-2 md:px-20">
            @csrf
            @method('PUT')

            <!-- Project Name -->
            <div class="mb-6 relative">
                <x-text-input
                    id="project_title"
                    name="project_title"
                    type="text"
                    class="block w-full peer"
                    :value="old('project_title', $project->project_title)"
                    required
                    placeholder=" " />
                <x-input-label for="project_title" :value="__('Nombre del proyecto')" />
                <x-input-error :messages="$errors->get('project_title')" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="mb-6 relative pt-3">
                <x-textarea
                    id="description"
                    name="description"
                    class="block w-full peer"
                    rows="4"
                    placeholder=" ">{{ old('description', $project->description) }}</x-textarea>
                <x-input-label for="description" :value="__('Descripción')" />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Color Selection -->
            <div class="mb-6 relative">
                <label for="color" class="font-body font-medium">Color</label>
                <x-select-input
                    id="color"
                    name="color"
                    class="block w-full peer">
                    @foreach($colors as $value => $label)
                    <option value="{{ $value }}" class="text-{{ $value }}-500">
                        {{ $label }}
                    </option>
                    @endforeach
                </x-select-input>
            </div>

            <!-- Buttons -->
            <div class="flex justify-center items-center mt-4 space-x-2">
                <x-secondary-button
                    type="button"
                    onclick="history.back()"
                    class="w-1/2 md:w-auto">
                    {{ __('Cancelar') }}
                </x-secondary-button>
                <x-primary-button type="submit" class="w-1/2 md:w-auto">
                    {{ __('Actualizar') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection