@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Sección superior con título y botón -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mi Espacio</h1>

        <div class="grid grid-cols-2 gap-2 p-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            <div class="bg-slate-500 text-white h-16 flex items-center justify-center rounded">slate</div>
            <div class="bg-gray-500 text-white h-16 flex items-center justify-center rounded">gray</div>
            <div class="bg-zinc-500 text-white h-16 flex items-center justify-center rounded">zinc</div>
            <div class="bg-neutral-500 text-white h-16 flex items-center justify-center rounded">neutral</div>
            <div class="bg-stone-500 text-white h-16 flex items-center justify-center rounded">stone</div>
            <div class="bg-red-500 text-white h-16 flex items-center justify-center rounded">red</div>
            <div class="bg-orange-500 text-white h-16 flex items-center justify-center rounded">orange</div>
            <div class="bg-amber-500 text-white h-16 flex items-center justify-center rounded">amber</div>
            <div class="bg-yellow-500 text-black h-16 flex items-center justify-center rounded">yellow</div>
            <div class="bg-lime-500 text-black h-16 flex items-center justify-center rounded">lime</div>
            <div class="bg-green-500 text-white h-16 flex items-center justify-center rounded">green</div>
            <div class="bg-emerald-500 text-white h-16 flex items-center justify-center rounded">emerald</div>
            <div class="bg-teal-500 text-white h-16 flex items-center justify-center rounded">teal</div>
            <div class="bg-cyan-500 text-white h-16 flex items-center justify-center rounded">cyan</div>
            <div class="bg-sky-500 text-white h-16 flex items-center justify-center rounded">sky</div>
            <div class="bg-blue-500 text-white h-16 flex items-center justify-center rounded">blue</div>
            <div class="bg-indigo-500 text-white h-16 flex items-center justify-center rounded">indigo</div>
            <div class="bg-violet-500 text-white h-16 flex items-center justify-center rounded">violet</div>
            <div class="bg-purple-500 text-white h-16 flex items-center justify-center rounded">purple</div>
            <div class="bg-fuchsia-500 text-white h-16 flex items-center justify-center rounded">fuchsia</div>
            <div class="bg-pink-500 text-white h-16 flex items-center justify-center rounded">pink</div>
            <div class="bg-rose-500 text-white h-16 flex items-center justify-center rounded">rose</div>
        </div>

        <div class="grid grid-cols-2 gap-3 p-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            <!-- Grises -->
            <div class="border-2 border-slate-500 bg-slate-100 text-slate-500 h-16 flex items-center justify-center rounded-lg font-medium">slate</div>
            <div class="border-2 border-gray-500 bg-gray-100 text-gray-500 h-16 flex items-center justify-center rounded-lg font-medium">gray</div>
            <div class="border-2 border-zinc-500 bg-zinc-100 text-zinc-500 h-16 flex items-center justify-center rounded-lg font-medium">zinc</div>
            <div class="border-2 border-neutral-500 bg-neutral-100 text-neutral-500 h-16 flex items-center justify-center rounded-lg font-medium">neutral</div>
            <div class="border-2 border-stone-500 bg-stone-100 text-stone-500 h-16 flex items-center justify-center rounded-lg font-medium">stone</div>

            <!-- Colores cálidos -->
            <div class="border-2 border-red-500 bg-red-100 text-red-500 h-16 flex items-center justify-center rounded-lg font-medium">red</div>
            <div class="border-2 border-orange-500 bg-orange-100 text-orange-500 h-16 flex items-center justify-center rounded-lg font-medium">orange</div>
            <div class="border-2 border-amber-500 bg-amber-100 text-amber-500 h-16 flex items-center justify-center rounded-lg font-medium">amber</div>
            <div class="border-2 border-yellow-500 bg-yellow-100 text-yellow-500 h-16 flex items-center justify-center rounded-lg font-medium">yellow</div>

            <!-- Verdes -->
            <div class="border-2 border-lime-500 bg-lime-100 text-lime-500 h-16 flex items-center justify-center rounded-lg font-medium">lime</div>
            <div class="border-2 border-green-500 bg-green-100 text-green-500 h-16 flex items-center justify-center rounded-lg font-medium">green</div>
            <div class="border-2 border-emerald-500 bg-emerald-100 text-emerald-500 h-16 flex items-center justify-center rounded-lg font-medium">emerald</div>

            <!-- Azules -->
            <div class="border-2 border-teal-500 bg-teal-100 text-teal-500 h-16 flex items-center justify-center rounded-lg font-medium">teal</div>
            <div class="border-2 border-cyan-500 bg-cyan-100 text-cyan-500 h-16 flex items-center justify-center rounded-lg font-medium">cyan</div>
            <div class="border-2 border-sky-500 bg-sky-100 text-sky-500 h-16 flex items-center justify-center rounded-lg font-medium">sky</div>
            <div class="border-2 border-blue-500 bg-blue-100 text-blue-500 h-16 flex items-center justify-center rounded-lg font-medium">blue</div>

            <!-- Púrpuras -->
            <div class="border-2 border-indigo-500 bg-indigo-100 text-indigo-500 h-16 flex items-center justify-center rounded-lg font-medium">indigo</div>
            <div class="border-2 border-violet-500 bg-violet-100 text-violet-500 h-16 flex items-center justify-center rounded-lg font-medium">violet</div>
            <div class="border-2 border-purple-500 bg-purple-100 text-purple-500 h-16 flex items-center justify-center rounded-lg font-medium">purple</div>
            <div class="border-2 border-fuchsia-500 bg-fuchsia-100 text-fuchsia-500 h-16 flex items-center justify-center rounded-lg font-medium">fuchsia</div>

            <!-- Rosas -->
            <div class="border-2 border-pink-500 bg-pink-100 text-pink-500 h-16 flex items-center justify-center rounded-lg font-medium">pink</div>
            <div class="border-2 border-rose-500 bg-rose-100 text-rose-500 h-16 flex items-center justify-center rounded-lg font-medium">rose</div>
        </div>

        <div class="flex space-x-3">
            <a href="{{ route('tasks.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nueva Tarea
            </a>
            <a href="{{ route('projects.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nuevo Proyecto
            </a>
        </div>
    </div>

    <!-- Grid principal con habitación y tareas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna izquierda - Habitación -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-700">Mi Habitación</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('room.edit') }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                        Configurar
                    </a>
                    <a href="#" class="text-green-500 hover:text-green-700 text-sm font-medium">
                        Tienda
                    </a>
                </div>
            </div>

            <div class="bg-gray-200 p-4 rounded-b-lg" style="min-height: 400px; position: relative;">
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
                    <div class="text-center p-6 bg-white rounded-lg shadow-sm max-w-md">
                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Habitación vacía</h3>
                        <p class="mt-1 text-gray-500">Añade muebles desde la tienda para personalizar tu espacio</p>
                        <div class="mt-4">
                            <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                Visitar tienda
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
                @else
                <div class="flex items-center justify-center h-full">
                    <div class="text-center p-6 bg-white rounded-lg shadow-sm max-w-md">
                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"></path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Habitación no configurada</h3>
                        <p class="mt-1 text-gray-500">Configura tu habitación para personalizar tu espacio de trabajo</p>
                        <div class="mt-4">
                            <a href="{{ route('room.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                                Configurar habitación
                            </a>
                        </div>
                    </div>
                </div>
                @endisset
            </div>
        </div>

        <!-- Columna derecha - Tareas -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-700">Mis Tareas</h2>
                <a href="{{ route('tasks.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Ver todas
                </a>
            </div>

            <div class="divide-y divide-gray-200">
                @isset($tasks)

                @forelse($tasks->take(5) as $task)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3 flex-1">
                            <!-- Checkbox completado -->
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

                            <!-- Detalles de la tarea -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium text-gray-800 {{ $task->completed ? 'line-through' : '' }} truncate">
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
                                @if($task->description)
                                <p class="text-sm text-gray-500 mt-1 truncate">{{ $task->description }}</p>
                                @endif
                                @if($task->project)
                                <span class="inline-block mt-2 px-2 py-0.5 text-xs font-medium text-{{ $task->project->color }}-800 bg-{{ $task->project->color }}-100 rounded-full">
                                    {{ $task->project->name }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Acciones -->
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

                    <!-- Checklist -->
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
                    </div>
                    @endif

                    <!-- Formulario para nuevo checklist -->
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
                <p>No hay tareas disponibles</p>
                @endisset
            </div>
        </div>
    </div>

    <!-- Sección de proyectos -->
    <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
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