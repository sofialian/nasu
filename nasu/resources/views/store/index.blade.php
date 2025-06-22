<!-- resources/views/store/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if (session('info'))
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
        {{ session('info') }}
    </div>
    @endif

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Furniture store</h1>
        <div class="flex items-center">
            <span class="mr-2">Your Beans:</span>
            <span class="text-2xl font-bold text-yellow-600">{{ ($userBeans) }}</span>
            <img src="{{ asset('images/bean.png') }}" class="h-8 ml-1" alt="Beans">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Categories sidebar -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow p-4 sticky top-4">
                <h2 class="font-bold text-lg mb-4">Categories</h2>
                <ul class="space-y-2">
                    @foreach($categories as $category)
                    <li>
                        <a href="#{{ Str::slug($category) }}"
                            class="block px-3 py-2 rounded hover:bg-gray-100">
                            {{ ucfirst($category) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Furniture items -->
        <div class="md:col-span-3">
            @foreach ($furniture as $category => $items)
            <h2 class="text-xl font-bold mt-6 mb-2">{{ ucfirst($category) }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($items as $item)
                @php
                $owned = in_array($item->id, $ownedFurnitureIds);
                @endphp

                <div class="border rounded p-4 text-center 
                        {{ $owned ? 'opacity-50' : '' }}">
                    <img src="{{ asset($item->image_path) }}" class="mx-auto w-24 h-24 mb-2" alt="{{ $item->name }}">
                    <h3 class="font-semibold">{{ $item->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $item->description }}</p>
                    <p class="my-2 font-bold">{{ $item->price }} beans</p>

                    @if ($owned)
                    <span class="text-green-600 font-semibold">Owned</span>
                    @elseif (!$item->is_purchasable)
                    <button class="bg-gray-300 text-gray-600 px-3 py-1 rounded cursor-not-allowed" disabled>No disponible</button>
                    @else
                    <form method="POST" action="{{ route('store.purchase') }}">
                        @csrf
                        <input type="hidden" name="furniture_id" value="{{ $item->id }}">
                        @php
                        $canAfford = $userBeans >= $item->price;
                        @endphp

                        <button type="submit"
                            class="px-3 py-1 rounded w-full
        {{ $canAfford ? 'bg-blue-500 hover:bg-blue-600 text-white' : 'bg-gray-300 text-gray-600 cursor-not-allowed' }}"
                            {{ $canAfford ? '' : 'disabled' }}>
                            {{ $canAfford ? 'Comprar' : 'Sin beans' }}
                        </button>

                    </form>
                    @endif
                </div>
                @endforeach
            </div>
            @endforeach

        </div>
    </div>
</div>
@endsection