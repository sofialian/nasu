@extends('layouts.app')

@section('header', 'Crear Nuevo Proyecto')

@section('content')
<div class="flex-grow flex items-center justify-center mt-8 flex flex-col container">
    <div class="w-full max-w-4xl text-primary-dark mb-8 text-base page">
        <div class="uppercase font-title text-xl text-center mb-6">Crear Proyecto</div>
        <form action="{{ route('projects.store') }}" method="POST" class="p-6 md:px-20">
            @csrf

            <div class="mb-4 relative">
                <x-text-input
                    id="title"
                    class="block w-full"
                    type="text"
                    name="title"
                    required
                    placeholder=" " />
                <x-input-label for="title" :value="__('Nombre del proyecto')" />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- Description Field -->
             <div class="mb-4 relative py-2">
                <x-textarea 
                    id="description" 
                    name="description" 
                    class="block w-full peer min-h-[120px]" 
                    rows="3"
                    placeholder=" "
                ></x-textarea>
                <x-input-label for="description" :value="__('Descripción')" />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Color Selection (unchanged functionality) -->
            <div class="mb-4">
                <label for="color" class="font-body font-medium">Color</label>
                <select 
                    id="color" 
                    name="color" 
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                    required
                >
                    @foreach($colors as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submit Button (unchanged functionality) -->
            <div class="flex justify-center items-center mt-8 space-x-2">
                <x-secondary-button
                    type="button"
                    onclick="history.back()"
                    class="w-1/2 md:w-auto">
                    {{ __('Cancelar') }}
                </x-secondary-button>
                <x-primary-button type="submit" class="w-1/2 md:w-auto">
                    {{ __('Crear') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection