@extends('layouts.app')

@section('header', 'Mis Tareas')

@section('content')

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transition-opacity duration-300" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
    {{ session('success') }}
    <button @click="show = false" class="ml-4 text-white hover:text-gray-200">
        &times;
    </button>
</div>
@endif


<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mis Tareas</h1>
        <a href="{{ route('tasks.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors">
            + Nueva Tarea
        </a>
    </div>

    @if($tasks->isEmpty())
    <div class="bg-white p-6 rounded-lg shadow text-center">
        <p class="text-gray-500">No tienes tareas aún. ¡Crea tu primera tarea!</p>
    </div>
    @else
    <div class="grid gap-4">
        @foreach($tasks as $task)
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start">
                <div class="flex items-start space-x-4 flex-1">
                    <!-- Checkbox completado -->
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="completed" value="{{ $task->completed ? '0' : '1' }}">
                        <button type="submit" class="mt-1 focus:outline-none">
                            <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center {{ $task->completed ? 'bg-green-500 border-green-500' : '' }}">
                                @if($task->completed)
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                @endif
                            </div>
                        </button>
                    </form>

                    <!-- Detalles de la tarea -->
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <h3 class="text-lg font-medium {{ $task->completed ? 'line-through text-gray-500' : 'text-gray-800' }}">
                                    {{ $task->task_title }}
                                </h3>
                                @if($task->project)
                                <span class="px-2 py-1 text-xs font-bold text-{{ $task->project->color }}-500 bg-{{ $task->project->color }}-100 rounded-full">
                                    {{ $task->project->project_title }}
                                </span>
                                <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">
                                    {{ $task->project->project_title }} (Color: {{ $task->project->color }})
                                </span>
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button id="deleteTask" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($task->description)
                        <p class="text-gray-600 mt-2">{{ $task->description }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Checklist -->
            <div class="mt-4 pl-10 border-t pt-4">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-sm font-medium text-gray-500">Checklist</h4>
                </div>

                <form action="{{ route('checklists.store', $task) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="flex gap-2">
                        <x-text-input class="flex-1" type="text" name="item" placeholder="Nuevo item" required />
                        <x-primary-button type="submit">Añadir</x-primary-button>
                    </div>
                </form>

                @if($task->checklists->isNotEmpty())
                <ul class="space-y-2">
                    @foreach($task->checklists as $item)
                    <li class="flex items-center justify-between group">
                        <form action="{{ route('checklists.update', $item) }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PUT')
                            <input type="checkbox" onchange="this.form.submit()" {{ $item->completed ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 mr-2">
                            <span class="{{ $item->completed ? 'line-through text-gray-400' : 'text-gray-600' }}">
                                {{ $item->item }}
                            </span>
                        </form>
                        <form action="{{ route('checklists.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 opacity-0 group-hover:opacity-100 transition-opacity">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </form>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
<script>
        function confirmDelete() {
            if (confirm('¿Estás seguro de que deseas eliminar esta tarea? Esta acción no se puede deshacer.')) {
                document.getElementById('deleteTask').submit();
            }
        }
    </script>
@endsection