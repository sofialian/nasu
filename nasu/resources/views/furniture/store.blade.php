@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Furniture Store -->
        <div class="md:col-span-3">
            <h2 class="text-2xl font-bold mb-4">Furniture Store</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($furniture as $item)
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="w-full h-32 object-contain mb-2">
                    <h3 class="font-medium">{{ $item->name }}</h3>
                    <p class="text-gray-600">${{ number_format($item->price, 2) }}</p>
                    <form action="{{ route('room.add-furniture') }}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="furniture_id" value="{{ $item->id }}">
                        <button type="submit" class="w-full bg-blue-500 text-white py-1 rounded hover:bg-blue-600">
                            Add to Room
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>

        <!-- User's Current Room Preview -->
        <div class="border rounded-lg p-4 bg-gray-50">
            <h2 class="text-xl font-bold mb-4">Your Room</h2>
            @foreach($userFurniture as $index => $item)
            <div class="flex items-center mb-3 p-2 bg-white rounded border">
                <img src="{{ asset($item['image']) }}" class="w-12 h-12 object-contain mr-2">
                <div class="flex-1">
                    <h4>{{ $item['name'] }}</h4>
                    <p class="text-xs text-gray-500">Position: {{ $item['x'] }}, {{ $item['y'] }}</p>
                </div>
                <form action="{{ route('room.remove-furniture', $index) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
            @endforeach
            @empty($userFurniture)
                <p class="text-gray-500">Your room is empty. Add some furniture!</p>
            @endempty
        </div>
    </div>
</div>
@endsection