@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Room</h1>
        <a href="{{ route('room.edit', $room) }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Edit Room
        </a>
    </div>

    <!-- Room Display Area -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="room-container relative bg-gray-100 rounded-lg" 
             style="min-height: 500px; background-color: #f3f4f6;">
            
            @foreach($room->items as $item)
            <div class="furniture-item absolute cursor-move" 
                 style="left: {{ $item->position_x }}px; top: {{ $item->position_y }}px;"
                 data-item-id="{{ $item->id }}">
                <img src="{{ asset($item->userFurniture->furniture->image_path) }}" 
                     alt="{{ $item->userFurniture->furniture->name }}"
                     class="w-16 h-16 object-contain">
            </div>
            @endforeach
        </div>
    </div>

    <!-- Available Furniture -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Available Furniture</h2>
        
        @if($availableFurniture->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($availableFurniture as $item)
            <div class="furniture-item bg-gray-50 p-3 rounded-lg cursor-pointer"
                 data-furniture-id="{{ $item->id }}">
                <img src="{{ asset($item->furniture->image_path) }}" 
                     alt="{{ $item->furniture->name }}"
                     class="w-full h-24 object-contain mb-2">
                <p class="text-center text-sm">{{ $item->furniture->name }}</p>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500">You don't have any furniture available to place.</p>
        @endif
    </div>
</div>
@endsection