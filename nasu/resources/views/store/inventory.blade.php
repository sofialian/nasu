<!-- resources/views/shop/inventory.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Your Inventory</h1>
        <div class="flex items-center">
            <span class="mr-2">Your Beans:</span>
            <span class="text-2xl font-bold text-yellow-600">{{ number_format($userBeans) }}</span>
            <img src="{{ asset('images/bean.png') }}" class="h-8 ml-1" alt="Beans">
        </div>
    </div>

    @if($ownedFurniture->isEmpty())
    <div class="bg-white rounded-lg shadow p-8 text-center">
        <p class="text-gray-500">Your inventory is empty</p>
        <a href="{{ route('shop.index') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Visit Shop
        </a>
    </div>
    @else
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($ownedFurniture as $item)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 h-32 flex items-center justify-center bg-gray-50">
                <img src="{{ asset($item->image_path) }}" 
                     alt="{{ $item->name }}"
                     class="max-h-full max-w-full object-contain">
            </div>
            <div class="p-3 border-t">
                <h3 class="font-medium text-sm truncate">{{ $item->name }}</h3>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-xs text-gray-500">Owned</span>
                    <button class="px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700"
                            onclick="prepareToPlace({{ $item->id }})">
                        Place
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<script>
function prepareToPlace(furnitureId) {
    // You'll implement this later to handle placing furniture in the room
    alert('Ready to place item #' + furnitureId + ' in your room!');
    // This would typically open the room editor with this item selected
}
</script>
@endsection