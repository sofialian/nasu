<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="container mx-auto my-auto h-1/3">
        <div class="bg-gray-200 p-4 rounded-lg" style="height: 400px; position: relative;">
            @isset($room)
            @forelse($room->items as $item)
            @isset($item->furniture)
            <div class="absolute bg-cover bg-center"
                style="left: {{ $item->position_x }}px;
                            top: {{ $item->position_y }}px;
                            width: 80px;
                            height: 80px;
                            background-image: url('{{ $item->furniture->image_url }}');
                            transform: rotate({{ $item->rotation }}deg);"
                title="{{ $item->furniture->name }}">
            </div>
            @endisset
            @empty
            <p class="text-gray-500 text-center mt-40">No tienes muebles en tu habitación. ¡Visita la tienda!</p>
            @endforelse
            @else
            <p class="text-gray-500 text-center mt-40">No hay habitación configurada.</p>
            @endisset
        </div>

        <div class="flex justify-center mt-4">
            <a href="{{ route('room.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md">Configurar habitación</a>
            <a href="#" class="bg-green-500 text-white px-4 py-2 rounded-md ml-4">Visitar tienda</a>
            <a href="{{ route('profile.edit') }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md ml-4">Editar perfil</a>
        </div>

        <div class="border-3 border-orange-500">container mobile first usar z-index para superponer los elementos
            <div class="border-2 border-cyan-500">task</div>
            <div class="border-2 border-pink-500">projects</div>
        </div>

    </div>
    @endsection
</x-app-layout>