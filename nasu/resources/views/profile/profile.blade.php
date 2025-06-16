@extends('layouts.app')
@section('header', 'Perfil')
@section('content')
<div class="mt-12">
    <h1 class="uppercase font-title text-lg text-primary-dark">@yield('header')</h1>
    <div class="page md:mx-20 p-6 rounded-lg shadow">
        <!-- Header with Edit Button -->
        <div class="flex justify-between items-center mb-4">
        <h1 class="uppercase font-body font-semibold text-lg text-primary-dark">
                {{ $user->name }}
            </h1>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-1 px-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Editar</span>
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="font-body font-medium text-gray-500 mb-1">Habichuelas</h3>
                <p class="text-2xl font-bold text-primary-dark">{{ $user->balance->beans }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="font-body font-medium text-gray-500 mb-1">Muebles</h3>
                <p class="text-2xl font-bold text-primary-dark">{{ $user->ownedFurniture->count() }}</p>
            </div>
        </div>

        <!-- Room Section -->
        <div class="mb-2">
            <h2 class="font-body font-medium text-gray-700">Tu Habitación</h2>
        </div>

        @if($user->room->items->count())
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
            @foreach($user->room->items as $item)
            <div class="relative group">
                <div class="aspect-square bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center p-2">
                    <img src="{{ asset($item->furniture->image_path) }}"
                        alt="{{ $item->furniture->name }}"
                        class="w-full h-full object-contain">
                </div>
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all rounded-lg"></div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 text-center">
            <p class="text-gray-500">No hay muebles en tu habitación</p>
        </div>
        @endif
    </div>
</div>
@endsection