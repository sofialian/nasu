@extends('layouts.app')

@section('header', 'Editar Proyecto')

@section('content')
<form action="{{ route('projects.update', $project) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <x-input-label for="project_title" :value="__('Nombre del proyecto')" />
        <x-text-input id="project_title" name="project_title"
            :value="old('project_title', $project->project_title)" required />
        <x-input-error :messages="$errors->get('project_title')" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-input-label for="description" :value="__('Descripción')" />
        <textarea id="description" name="description"
            class="block w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $project->description) }}</textarea>
    </div>

    <div class="mb-4">
        <x-input-label for="color" :value="__('Color')" />
        <select id="color" name="color" class="block w-full border-gray-300 rounded-md shadow-sm">
            @foreach(['red' => 'Rojo', 'blue' => 'Azul', 'green' => 'Verde'] as $value => $label)
            <option value="{{ $value }}"
                {{ $project->color == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="flex justify-end">
        <x-primary-button type="submit">
            Actualizar Proyecto
        </x-primary-button>
    </div>
</form>
@endsection