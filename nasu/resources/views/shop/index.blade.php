<!-- resources/views/shop/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Furniture Shop</h1>
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
            @foreach($furniture as $category => $items)
            <section id="{{ Str::slug($category) }}" class="mb-12">
                <h2 class="text-2xl font-bold mb-4">{{ ucfirst($category) }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($items as $item)
                    <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-4 h-40 flex items-center justify-center bg-gray-50">
                            <img src="{{ asset($item->image_path) }}" 
                                 alt="{{ $item->name }}"
                                 class="max-h-full max-w-full object-contain">
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold">{{ $item->name }}</h3>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-yellow-600 font-bold">
                                    {{ number_format($item->price) }} Beans
                                </span>
                                <form action="{{ route('shop.purchase') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="furniture_id" value="{{ $item->id }}">
                                    <button type="submit" 
                                            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 
                                                   {{ $userBeans < $item->price ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            {{ $userBeans < $item->price ? 'disabled' : '' }}>
                                        Buy
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endforeach
        </div>
    </div>
</div>
@endsection