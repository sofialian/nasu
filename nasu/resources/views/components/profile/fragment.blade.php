@props(['user'])

<div class="">
    <div class="border border-primary-dark p-1 px-2 shadow">
        <div class="flex justify-between items-center">
            <h1 class="uppercase font-body font-semibold text-sm text-primary-dark">
                {{ $user->name }}
            </h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-4">
            <div class="">
                <h4 class="font-body font-medium text-gray-500 mb-1">Habichuelas</h4>
                <p class="text-lg font-medium text-primary-dark">{{ $user->balance->beans }}</p>
            </div>
            <div class="">
                <h4 class="font-body font-medium text-gray-500 mb-1">Muebles</h4>
                <p class="text-lg font-medium text-primary-dark">{{ $user->ownedFurniture->count() }}</p>
            </div>
        </div>

        <!-- <div class="mb-2">
            <h2 class="font-body font-medium text-gray-700">Tu Habitación</h2>
        </div>

        @if($user->room->items->count())
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
            @foreach($user->room->items as $item)
            <div class="relative group">
                <div class="aspect-square bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center p-2">
                    <img src="{{ asset($item->furniture->image_path) }}" alt="{{ $item->furniture->name }}"
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
        @endif -->
    </div>
</div>
