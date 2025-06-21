@extends('layouts.app')
@section('header', 'Mi habitación')
@section('content')
<div class="container flex flex-col justify-center items-center">
    <h1 class="font-title">@yield('header')</h1>
    <div class="">
        <div class="row">
            <!-- Room Display -->
            <div class="col-md-8">
                <div class="room-display"
                    style="position: relative; 
                        height: 60vh; 
                        width: 60vh;
                        border: 1px solid #ccc;
                        background-color: #f5f5f5;
                        margin: 0 auto;
                        overflow: visible;">
                    @foreach($furnitureItems as $item)
                    <div class="furniture-item"
                        style="position: absolute;
                                left: {{ $item['x'] }}px;
                                top: {{ $item['y'] }}px;
                                transform: rotate({{ $item['rotation'] }}deg);
                                transition: all 0.3s ease;">
                        <img src="{{ asset($item['image']) }}"
                            alt="{{ $item['name'] }}"
                            style="width: 100px; height: auto;">
                        <div class="item-name text-sm">{{ $item['name'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Available Furniture -->

        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('room.edit', $room) }}" class="block bg-accent hover:opacity-70 text-primary-light 
        py-3 px-5 transition duration-200 text-center w-ful text-base md:text-lg">
            Editar
        </a>
    </div>
</div>


@push('styles')
<style>
    .draggable {
        transition: transform 0.1s ease;
    }

    .draggable:hover {
        transform: scale(1.05);
    }

    .dragging {
        opacity: 0.5;
        transform: scale(1.1);
    }

    .room-display {
        transition: background-color 0.3s ease;
    }
</style>
@endpush
@endsection