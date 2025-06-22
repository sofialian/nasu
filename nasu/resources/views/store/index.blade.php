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
        <h1 class="text-3xl flex-1 font-title">Tienda</h1>
        <div class="flex items-center">
            <!-- <span class="mr-2 font-body font-normal">Your Beans:</span> -->
            <span class="text-2xl font-body font-semibold text-yellow-600">{{ ($userBeans) }}</span>
            <img src="{{ asset('images/bean.png') }}" class="h-8 ml-1" alt="Beans">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Categories sidebar -->
        <div class="md:col-span-1">
            <div class="border-2 border-secondary-color rounded-lg shadow p-4 sticky top-4">
                <h2 class="font-medium text-center font-body text-lg mb-4">Categorias</h2>
                <ul class="space-y-2">
                    <li class="border-b border-secondary-color">
                        <a href="#all" class="block px-3 py-2 hover:border-b-2 border-secondary-color hover:bg-[#97d5ca]/30
;
">
                            All Items
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li>
                        <a href="#{{ Str::slug($category) }}"
                            class="block px-3 py-2 hover:border-b-2 category-filter border-b border-secondary-color"
                            data-category="{{ Str::slug($category) }}">
                            {{ ucfirst($category) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Furniture items -->
        <div class="md:col-span-3" id="furniture-container">
            @foreach ($furniture as $category => $items)
            <div class="category-section" id="{{ Str::slug($category) }}">
                <h2 class="text-xl font-bold mt-6 mb-2">{{ ucfirst($category) }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($items as $item)
                    @php
                    $owned = in_array($item->id, $ownedFurnitureIds);
                    @endphp

                    <div class="border rounded border-gray-400 p-4 text-center 
                            {{ $owned ? 'opacity-50' : '' }}"
                        data-category="{{ Str::slug($category) }}">
                        <img src="{{ asset($item->image_path) }}" class="mx-auto w-24 h-24 mb-2" alt="{{ $item->name }}">
                        <h3 class="font-semibold font-body">{{ $item->name }}</h3>
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
                                class="px-3 py-1 rounded w-auto
                                    {{ $canAfford ? 'bg-blue-500 hover:bg-blue-600 text-white' : 'bg-gray-300 text-gray-600 cursor-not-allowed' }}"
                                {{ $canAfford ? '' : 'disabled' }}>
                                {{ $canAfford ? 'Comprar' : 'Sin beans' }}
                            </button>
                        </form>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtro por categoría
        const categoryLinks = document.querySelectorAll('.category-filter');
        const allItemsLink = document.querySelector('a[href="#all"]');
        const categorySections = document.querySelectorAll('.category-section');
        const furnitureItems = document.querySelectorAll('#furniture-container > div > div > div');

        // Mostrar todos los items al hacer clic en "All Items"
        allItemsLink.addEventListener('click', function(e) {
            e.preventDefault();

            categorySections.forEach(section => {
                section.style.display = 'block';
            });

            // Actualizar clase activa
            categoryLinks.forEach(link => link.classList.remove('bg-gray-200', 'font-medium'));
            this.classList.add('bg-gray-200', 'font-medium');
        });

        // Filtro por categoría específica
        categoryLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const category = this.getAttribute('data-category');

                categorySections.forEach(section => {
                    if (section.id === category) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });

                // Actualizar clase activa
                categoryLinks.forEach(link => link.classList.remove('bg-gray-200', 'font-medium'));
                allItemsLink.classList.remove('bg-gray-200', 'font-medium');
                this.classList.add('bg-gray-200', 'font-medium');
            });
        });

        // Manejar hash en la URL al cargar la página
        if (window.location.hash) {
            const hash = window.location.hash.substring(1);
            if (hash === 'all') {
                allItemsLink.click();
            } else {
                const matchingLink = document.querySelector(`.category-filter[data-category="${hash}"]`);
                if (matchingLink) {
                    matchingLink.click();
                }
            }
        }
    });
</script>

<style>
    .category-filter:hover {
        border-bottom: 2px solid #97d5ca;
        background-color: #97d5ca4D;
    }
</style>
@endsection