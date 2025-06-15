@extends('layouts.app')

@section('header', 'Mis Tareas')

@section('content')
@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg text-sm md:text-base md:px-6 md:py-3"
    x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
    {{ session('success') }}
    <button @click="show = false" class="ml-2 md:ml-4 text-white hover:text-gray-200">
        &times;
    </button>
</div>
@endif

<div class="container mx-auto px-4 md:px-40 py-6">
    <h1 class="font-title text-2xl md:text-3xl">Mis tareas</h1>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        <a href="{{ route('tasks.create') }}"
            class="bg-indigo-600 text-white px-4 py-2 hover:bg-indigo-700 transition-colors text-center w-full md:w-auto">
            + Nueva Tarea
        </a>
    </div>

    @if($tasks->isEmpty())
    <div class="bg-white p-6 rounded-lg shadow text-center">
        <p class="text-gray-500">No tienes tareas aún. ¡Crea tu primera tarea!</p>
    </div>
    @else
    <div class="grid gap-4 md:gap-6">
        @foreach($tasks as $task)
        <div class="border-2 border-secondary-color p-4 sm:p-6 rounded-lg shadow hover:shadow-md transition-shadow">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                <div class="flex items-start gap-3 sm:gap-4 flex-1">
                    <!-- Checkbox completado -->
                    <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="mt-1">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="focus:outline-none" x-data="{ completed: {{ $task->completed ? 'true' : 'false' }} }"
                            @click.prevent="completed = !completed; $el.closest('form').submit();">
                            <div class="w-5 h-5 sm:w-6 sm:h-6 border-2 rounded-full flex items-center justify-center transition-colors duration-200"
                                :class="{
                                    'bg-green-500 border-green-500': completed,
                                    'border-gray-300 hover:border-gray-400': !completed
                                }">
                                <svg x-show="completed" class="w-3 h-3 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </button>
                    </form>

                    <!-- Detalles de la tarea -->
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-base sm:text-lg font-medium break-words {{ $task->completed ? 'line-through text-gray-500' : 'text-gray-800' }}">
                                    {{ $task->task_title }}
                                </h3>
                                @if($task->project)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full whitespace-nowrap
                                    bg-{{ $task->project->color }}-100 text-{{ $task->project->color }}-800">
                                    {{ $task->project->project_title }}
                                </span>
                                @endif
                            </div>
                            <div class="flex gap-2 sm:gap-3">
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-500 hover:text-blue-700" title="Editar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Eliminar"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($task->description)
                        <p class="text-gray-600 mt-2 text-sm sm:text-base break-words">{{ $task->description }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Checklist -->
            <div class="mt-4 pl-0 sm:pl-10 border-t pt-4">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-medium text-gray-500">Checklist</h4>
                </div>

                <form action="{{ route('checklists.store', $task) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-2">
                        <x-text-input class="flex-1 w-full" type="text" name="item" placeholder="Nuevo item" required />
                        <x-secondary-button type="submit" class="w-full sm:w-auto justify-center font-normal">Añadir</x-secondary-button>
                    </div>
                </form>

                @if($task->checklists->isNotEmpty())
                <ul class="space-y-3">
                    @foreach($task->checklists as $item)
                    <li class="flex items-center justify-between group">
                        <form action="{{ route('checklists.update', $item) }}" method="POST" class="flex items-center flex-1 min-w-0">
                            @csrf
                            @method('PUT')
                            <input type="checkbox" onchange="this.form.submit()" {{ $item->completed ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 mr-2 h-4 w-4">
                            <span class="{{ $item->completed ? 'line-through text-gray-400' : 'text-gray-600' }} break-words flex-1">
                                {{ $item->item }}
                            </span>
                        </form>
                        <form action="{{ route('checklists.destroy', $item) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 opacity-0 group-hover:opacity-100 transition-opacity ml-2"
                                onclick="return confirm('¿Eliminar este item?')">
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
@endsection