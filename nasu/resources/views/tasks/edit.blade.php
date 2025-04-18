@extends('layouts.app')

@section('header', 'Editar Tarea')

@section('content')
    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <x-input-label for="title" :value="__('Título')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $task->title)" required />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>
        
        <div class="mb-4">
            <x-input-label for="description" :value="__('Descripción')" />
            <x-textarea id="description" class="block mt-1 w-full" name="description" rows="3">{{ old('description', $task->description) }}</x-textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>
        
        <div class="mb-4">
            <x-input-label for="project_id" :value="__('Proyecto')" />
            <x-select-input id="project_id" name="project_id" class="block mt-1 w-full">
                <option value="">Sin proyecto</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </x-select-input>
        </div>
        
        <div class="block mb-4">
            <label for="completed" class="inline-flex items-center">
                <x-checkbox-input id="completed" name="completed" :checked="old('completed', $task->completed)" />
                <span class="ml-2 text-sm text-gray-600">{{ __('Completada') }}</span>
            </label>
        </div>
        
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Actualizar') }}
            </x-primary-button>
        </div>
    </form>
    
    <hr class="my-6">
    
    <h3 class="text-lg font-medium text-gray-900 mb-4">Checklist</h3>
    
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
        <li class="py-4 flex items-center justify-between">
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
@endsection