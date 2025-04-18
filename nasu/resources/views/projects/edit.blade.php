@extends('layouts.app')

@section('header', 'Editar Proyecto')

@section('content')
    <form action="{{ route('projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $project->name)" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        
        <div class="mb-4">
            <x-input-label for="description" :value="__('Descripción')" />
            <x-textarea id="description" class="block mt-1 w-full" name="description" rows="3">{{ old('description', $project->description) }}</x-textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>
        
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Actualizar') }}
            </x-primary-button>
        </div>
    </form>
@endsection