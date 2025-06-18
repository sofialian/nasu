@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-4 py-8 sm:py-6 mt-8">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('profile') }}" class="text-lg md:text-2xl font-bold font-body text-primary-dark px-2 hover:text-primary-darker transition-colors">
            Perfil
        </a>
        <div class="flex space-x-3">
            <a href="{{ route('tasks.create') }}" class="bg-indigo-600 text-primary-light px-3 py-2 hover:bg-indigo-700 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tarea
            </a>
            <a href="{{ route('projects.create') }}" class="bg-green-600 text-primary-light px-3 py-2  hover:bg-green-700 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Proyecto
            </a>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 w-full">
        <div class="lg:col-span-1 overflow-hidden w-full border-4 border-lime-500"></div>
        <!-- Room Column -->
        <div class="lg:col-span-1 bg-white rounded-lg shadow-md overflow-hidden w-full">
            <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-semibold font-body text-primary-dark">Mi Habitación</h2>
                <div class="flex space-x-2">
                    @isset($room)
                    <a href="{{ route('room.edit', $room) }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                        Configurar
                    </a>
                    @else
                    <span class="text-gray-500 text-sm font-medium">No hay habitación</span>
                    @endisset
                    <a href="#" class="text-green-500 hover:text-green-700 text-sm font-medium">
                        Tienda
                    </a>
                </div>
            </div>

            <div class="bg-gray-200 p-4 rounded-b-lg border-2 border-red-500" style="min-height: 400px; position: relative; overflow: hidden;">
                @isset($room)
                <div class="room-display aspect-square w-full max-w-xs mx-auto">
                    @foreach($room->items as $item)
                    <div class="furniture-item absolute"
                        style="left: {{ $item->x_position }}px;
                                   top: {{ $item->y_position }}px;
                                   transform: rotate({{ $item->rotation }}deg);
                                   width: 100px;
                                   max-width: 100%;">
                        <img src="{{ asset($item->furniture->image_path) }}"
                            alt="{{ $item->furniture->name }}"
                            class="w-full h-auto">
                        <div class="text-center text-xs mt-1 truncate">{{ $item->furniture->name }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    {{ $room->items->count() }} muebles colocados
                </div>
                @else
                <div class="flex items-center justify-center h-full">
                    <p class="text-gray-500">No hay habitación configurada</p>
                </div>
                @endisset
            </div>
        </div>
        <div class="lg:col-span-1 overflow-hidden w-full border-4 border-lime-500"></div>


        <!-- Tasks Column -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden w-full">
            <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-700">Mis Tareas</h2>
                <a href="{{ route('tasks.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Ver todas
                </a>
            </div>

            <div class="divide-y divide-gray-200 max-h-[500px]">
                @isset($tasks)
                @forelse($tasks->take(5) as $task)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3 flex-1">
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline" x-data="{ completed: {{ $task->completed ? 'true' : 'false' }} }">
                                @csrf
                                @method('PATCH')
                                <button
                                    type="submit"
                                    class="flex items-center justify-center w-5 h-5 rounded border-2 transition-all duration-200"
                                    :class="{
                                        'bg-green-500 border-green-500': completed,
                                        'border-gray-300 hover:border-gray-400': !completed
                                    }"
                                    @click="completed = !completed">
                                    <svg
                                        x-show="completed"
                                        class="w-3 h-3 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                            </form>

                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-800 {{ $task->completed ? 'line-through' : '' }} truncate">
                                    {{ $task->task_title }}
                                </h3>
                                @if($task->project)
                                <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium text-{{ $task->project->color }}-800 bg-{{ $task->project->color }}-100 rounded-full">
                                    {{ $task->project->project_title }}
                                </span>
                                @endif
                                @if($task->description)
                                <p class="text-sm text-gray-500 mt-1 truncate">{{ $task->description }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('tasks.edit', $task) }}" class="text-gray-400 hover:text-indigo-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    @if($task->checklists->isNotEmpty())
                    <div class="mt-3 pl-8">
                        <ul class="space-y-2">
                            @foreach($task->checklists as $item)
                            <li class="flex items-center justify-between group">
                                <form action="{{ route('checklists.update', $item) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="checkbox" onchange="this.form.submit()" {{ $item->completed ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 mr-2">
                                    <span class="text-sm {{ $item->completed ? 'line-through text-gray-400' : 'text-gray-600' }}">
                                        {{ $item->item_name }}
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
                    </div>
                    @endif

                    <form action="{{ route('checklists.store', $task) }}" method="POST" class="mt-3 pl-8">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" name="item" placeholder="Añadir item" required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <button type="submit" class="text-sm px-2 py-1 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                +
                            </button>
                        </div>
                    </form>
                </div>
                @empty
                <div class="p-6 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay tareas</h3>
                    <p class="mt-1 text-sm text-gray-500">Comienza creando una nueva tarea</p>
                    <div class="mt-4">
                        <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                            Crear tarea
                        </a>
                    </div>
                </div>
                @endforelse
                @else
                <div class="p-6 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay tareas disponibles</h3>
                </div>
                @endisset
            </div>
        </div>
    </div>

    <!-- Projects Section -->
    <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden w-full">
        <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700">Mis Proyectos</h2>
            <a href="{{ route('projects.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                Ver todos
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
            @forelse($projects->take(3) as $project)
            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full bg-{{ $project->color }}-500 mr-2"></span>
                        <h3 class="font-medium">{{ $project->project_title }}</h3>
                    </div>
                    <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded-full">
                        {{ $project->tasks_count }} tareas
                    </span>
                </div>

                @if($project->description)
                <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $project->description }}</p>
                @endif

                <div class="mt-3 flex justify-between items-center">
                    <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        Ver detalles
                    </a>
                    <div class="flex space-x-2">
                        <a href="{{ route('projects.edit', $project) }}" class="text-gray-400 hover:text-blue-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="md:col-span-2 lg:col-span-3 p-6 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay proyectos</h3>
                <p class="mt-1 text-sm text-gray-500">Organiza tus tareas creando proyectos</p>
                <div class="mt-4">
                    <a href="{{ route('projects.create') }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700">
                        Crear proyecto
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection


@push('styles')
<style>
    /* Mobile-specific adjustments */
    @media (max-width: 767px) {
        .container {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .room-display {
            transform: scale(0.95);
            transform-origin: top left;
            width: 100% !important;
        }

        .furniture-item {
            width: 80px !important;
            max-width: 20vw !important;
        }

        /* Task items adjustments */
        .divide-y>div {
            padding: 1rem;
        }
    }

    /* Prevent horizontal scrolling */
    html,
    body {
        max-width: 100%;
        overflow-x: hidden;
    }

    /* Ensure proper room display */
    .room-display {
        min-width: 100%;
        contain: content;
    }
</style>
@endpush