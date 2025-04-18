@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Sección superior con título y botón -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mi Espacio</h1>
        <div>
            <a href="{{ route('tasks.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors">
                + Nueva Tarea
            </a>
        </div>
    </div>

    <!-- Grid principal con habitación y tareas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna izquierda - Habitación -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-700">Mi Habitación</h2>
            </div>
            
            <div class="bg-gray-200 p-4 rounded-b-lg" style="height: 400px; position: relative; min-height: 400px;">
                @isset($room)
                    @forelse($room->items as $item)
                        @isset($item->furniture)
                        <div class="absolute bg-cover bg-center cursor-move hover:shadow-lg hover:z-10 transition-all"
                            style="left: {{ $item->position_x }}px;
                                    top: {{ $item->position_y }}px;
                                    width: 80px;
                                    height: 80px;
                                    background-image: url('{{ $item->furniture->image_url }}');
                                    transform: rotate({{ $item->rotation }}deg);"
                            title="{{ $item->furniture->name }}">
                        </div>
                        @endisset
                    @empty
                    <div class="flex items-center justify-center h-full">
                        <p class="text-gray-500 text-center">
                            No tienes muebles en tu habitación.<br>
                            ¡Visita la tienda para decorarla!
                        </p>
                    </div>
                    @endforelse
                @else
                <div class="flex items-center justify-center h-full">
                    <p class="text-gray-500 text-center">
                        No hay habitación configurada.<br>
                        Configúrala para personalizar tu espacio.
                    </p>
                </div>
                @endisset
            </div>

            <div class="p-4 bg-gray-50 border-t border-gray-200 flex justify-center space-x-4">
                <a href="{{ route('room.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">
                    Configurar habitación
                </a>
                <a href="#" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors ml-4">
                    Visitar tienda
                </a>
            </div>
        </div>

        <!-- Columna derecha - Tareas -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-700">Mis Tareas Recientes</h2>
            </div>
            
            <div class="p-4">
                @if(isset($tasks) && $tasks->count() > 0)
                    <ul class="space-y-3">
                        @foreach($tasks->take(5) as $task)
                        <li class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-3">
                                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="completed" value="{{ $task->completed ? '0' : '1' }}">
                                        <button type="submit" class="mt-1 focus:outline-none">
                                            <div class="w-5 h-5 border-2 border-gray-300 rounded-sm flex items-center justify-center {{ $task->completed ? 'bg-green-500 border-green-500' : '' }}">
                                                @if($task->completed)
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                @endif
                                            </div>
                                        </button>
                                    </form>
                                    
                                    <div>
                                        <h3 class="font-medium {{ $task->completed ? 'line-through text-gray-500' : 'text-gray-800' }}">
                                            {{ $task->title }}
                                        </h3>
                                        @if($task->project)
                                        <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium text-{{ $task->project->color }}-800 bg-{{ $task->project->color }}-100 rounded-full">
                                            {{ $task->project->name }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <a href="{{ route('tasks.edit', $task) }}" class="text-gray-400 hover:text-indigo-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    
                    @if($tasks->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('tasks.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                            Ver todas las tareas ({{ $tasks->count() }})
                        </a>
                    </div>
                    @endif
                @else
                <div class="text-center py-6">
                    <p class="text-gray-500 mb-4">No tienes tareas pendientes</p>
                    <a href="{{ route('tasks.create') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        Crear mi primera tarea
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sección de perfil y proyectos (para pantallas grandes) -->
    <div class="hidden lg:grid grid-cols-2 gap-6 mt-6">
        <!-- Proyectos -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-700">Mis Proyectos</h2>
            </div>
            
            <div class="p-4">
                @if(isset($projects) && $projects->count() > 0)
                    <ul class="space-y-2">
                        @foreach($projects->take(3) as $project)
                        <li class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-{{ $project->color }}-500 mr-3"></span>
                                <span>{{ $project->name }}</span>
                            </div>
                            <span class="text-sm text-gray-500">{{ $project->tasks_count }} tareas</span>
                        </li>
                        @endforeach
                    </ul>
                    
                    @if($projects->count() > 3)
                    <div class="mt-3 text-center">
                        <a href="{{ route('projects.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                            Ver todos los proyectos
                        </a>
                    </div>
                    @endif
                @else
                <div class="text-center py-4">
                    <p class="text-gray-500 mb-3">No tienes proyectos creados</p>
                    <a href="{{ route('tasks.create') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        Crear un proyecto
                    </a>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Perfil -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-700">Mi Perfil</h2>
            </div>
            
            <div class="p-4 flex items-center space-x-4">
                <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                    @if(Auth::user()->profile_photo_path)
                    <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}" alt="Foto de perfil" class="w-full h-full object-cover">
                    @else
                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    @endif
                </div>
                
                <div>
                    <h3 class="font-medium text-gray-800">{{ Auth::user()->name }}</h3>
                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                    <a href="{{ route('profile.edit') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium mt-1 inline-block">
                        Editar perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection