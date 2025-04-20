@extends('layouts.app')

@section('header', 'Crear Nuevo Proyecto')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <x-input-label for="title" :value="__('Nombre del proyecto')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="description" :value="__('Descripción')" />
            <x-textarea id="description" class="block mt-1 w-full" name="description" rows="3" />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="color" :value="__('Color')" />
            <select id="color" name="color" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                @foreach($colors as $value => $label)
                    <option value="{{ $value }}" class="text-{{ $value }}-600">
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end">
            <x-primary-button type="submit">
                {{ __('Crear Proyecto') }}
            </x-primary-button>
        </div>
    </form>
</div>
@endsection