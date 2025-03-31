@extends('layouts.app')

@section('content')
<div class="bg-gray-200 p-4 rounded-lg" style="height: 400px; position: relative;">
    @if(optional($room)->items->isNotEmpty())
        @foreach($room->items as $item)
            <div class="absolute bg-cover bg-center"
                 style="left: {{ $item->position_x }}px;
                        top: {{ $item->position_y }}px;
                        width: 80px;
                        height: 80px;
                        background-image: url('{{ $item->furniture->image_url }}');
                        transform: rotate({{ $item->rotation }}deg);"
                 title="{{ $item->furniture->name }}">
            </div>
        @endforeach
    @else
        <p class="text-gray-500 text-center mt-40">No tienes muebles en tu habitación. ¡Visita la tienda!</p>
    @endif
</div>
@endsection