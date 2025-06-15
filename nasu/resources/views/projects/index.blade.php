@extends('layouts.app')

@section('header', 'Mis Proyectos')

@section('content')
@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transition-opacity duration-300" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
    {{ session('success') }}
    <button @click="show = false" class="ml-4 text-white hover:text-gray-200">
        &times;
    </button>
</div>
@endif

<div class="container mx-auto px-4 py-6 md:px-20">

    <div class="flex justify-center items-start mb-6">
        <x-back-button class="" />
        <h1 class="font-title flex-1">@yield('header')</h1>
    </div>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('projects.create') }}" class="bg-green-600 text-white px-4 py-2 hover:bg-green-700 transition-colors">
            + Nuevo Proyecto
        </a>
    </div>

    @if($projects->isEmpty())
    <div class="bg-white p-6 rounded-lg shadow text-center">
        <p class="text-gray-500">No tienes proyectos creados aún.</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($projects as $project)
        <div class="border-2 border-secondary-color rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            <div class="p-4 border-b flex items-center justify-between bg-{{ $project->color }}-50">
                <span class="w-3 h-3 rounded-full bg-{{ $project->color }}-500 mr-2"></span>
                <h3 class="font-semibold text-lg text-{{ $project->color }}-800">{{ $project->project_title }}</h3>
                <span class="bg-secondary-color text-{{ $project->color }}-800 px-2 py-1 rounded-full text-xs">
                    {{ $project->tasks_count }} tareas
                </span>
            </div>
            <div class="p-4">
                @if($project->description)
                <p class="text-gray-600 mb-4">{{ Str::limit($project->description, 100) }}</p>
                @endif
                <div class="flex justify-between items-center">
                    <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        Ver detalles
                    </a>
                    <div class="flex space-x-2">
                        <a href="{{ route('projects.edit', $project) }}" class="text-gray-400 hover:text-blue-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $projects->links() }}
    </div>
    @endif
</div>
@endsection