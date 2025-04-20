@extends('layouts.app')
@section('header', 'Mis Proyectos')
@section('content')
@foreach(auth()->user()->projects as $project)
<div class="project-item bg-{{ $project->color }}-100 text-{{ $project->color }}-800">
    <h3>{{ $project->name }}</h3>
    <p>{{ $project->description }}</p>
    <span>{{ $project->tasks_count }} tareas</span>
</div>
@endforeach
@endsection