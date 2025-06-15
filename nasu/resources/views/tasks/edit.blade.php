@extends('layouts.app')

@section('header', 'Editar Tarea')

@section('content')
<div class="flex flex-col p-8 mt-4 justify-center items-center">
    <form action="{{ route('tasks.update', $task) }}" method="POST" class="md:w-1/2">
        @csrf
        @method('PUT')

        <!-- Title Input with Floating Label -->
        <div class="mb-6 relative">
            <x-text-input
                id="task_title"
                name="task_title"
                type="text"
                class="block w-full peer"
                :value="old('title', $task->task_title)"
                required
                placeholder=" " />
            <x-input-label for="task_title" :value="__('Título')" />
            <x-input-error :messages="$errors->get('task_title')" class="mt-2" />
        </div>

        <!-- Description Textarea with Floating Label -->
        <div class="mb-6 relative py-2">
            <x-textarea
                id="description"
                name="description"
                class="block w-full peer"
                rows="3"
                placeholder=" ">{{ old('description', $task->description) }}</x-textarea>
            <x-input-label for="description" :value="__('Descripción')" />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mb-4 relative">
            <label for="project_id" class="font-body font-medium">Proyecto</label>
            <x-select-input id="project_id" name="project_id" class="block mt-1 w-full">
                <option value="">Sin proyecto</option>
                @foreach($projects as $project)
                <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>
                    {{ $project->project_title }}
                </option>
                @endforeach
            </x-select-input>
        </div>

        <div class="block mb-4 relative">
            <label for="completed" class="inline-flex items-center">
                <x-checkbox-input id="completed" name="completed" :checked="old('completed', $task->completed)" />
                <span class="ml-2 text-sm text-gray-600">{{ __('Completada') }}</span>
            </label>
        </div>

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

    <hr class="my-6">

    <h3 class="text-lg font-medium text-gray-900 mb-4 relative">Checklist</h3>

    <form action="{{ route('checklists.store', $task) }}" method="POST" class="mb-6">
        @csrf
        <div class="flex gap-2">
            <x-text-input class="flex-1" type="text" name="item" placeholder="Nuevo item" required />
            <x-primary-button type="submit">
                {{ __('Añadir') }}
            </x-primary-button>
        </div>
    </form>

    <ul class="divide-y divide-gray-200">
        @foreach($task->checklists as $item)
        <li class="py-4 relative flex items-center justify-between">
            <div class="flex items-center">
                <form action="{{ route('checklists.update', $item) }}" method="POST" class="flex items-center">
                    @csrf
                    @method('PUT')
                    <x-checkbox-input onchange="this.form.submit()" :checked="$item->completed" class="mr-3" />
                    <span class="{{ $item->completed ? 'line-through text-gray-500' : 'text-gray-800' }}">
                        {{ $item->item }}
                    </span>
                </form>
            </div>
            <form action="{{ route('checklists.destroy', $item) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-danger-button type="submit">
                    {{ __('Eliminar') }}
                </x-danger-button>
            </form>
        </li>
        @endforeach
    </ul>
</div>
@endsection