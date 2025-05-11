@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Edit Your Room</h1>
    
    {{-- Room Editor --}}
    <div class="flex">
        {{-- Furniture Library (Drag items from here) --}}
        <div class="w-1/4 p-4 bg-white rounded-lg shadow-md mr-4">
            <h3 class="font-semibold mb-4">Your Furniture</h3>
            <div class="grid grid-cols-2 gap-2">
                @foreach($user->furniture as $item)
                    <div class="furniture-item p-2 border rounded cursor-grab" 
                         draggable="true"
                         data-id="{{ $item->id }}"
                         data-image="{{ asset($item->image_path) }}">
                        <img src="{{ asset($item->image_path) }}" class="w-full">
                        <p class="text-sm text-center mt-1">{{ $item->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Room Canvas --}}
        <div id="room-canvas" class="flex-1 bg-gray-100 rounded-lg relative" 
             style="height: 500px;">
            <!-- Furniture placed here will be saved via JS -->
        </div>
    </div>

    {{-- Save Button --}}
    <button id="save-room" class="mt-4 bg-green-500 text-white px-4 py-2 rounded-lg">
        Save Changes
    </button>
</div>

<script>
    // Drag-and-Drop Logic (Simplified)
    document.querySelectorAll('.furniture-item').forEach(item => {
        item.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('text/plain', e.target.dataset.id);
        });
    });

    const canvas = document.getElementById('room-canvas');
    canvas.addEventListener('dragover', (e) => e.preventDefault());
    canvas.addEventListener('drop', (e) => {
        e.preventDefault();
        const id = e.dataTransfer.getData('text/plain');
        const item = document.querySelector(`[data-id="${id}"]`);
        
        // Add to canvas
        const img = document.createElement('img');
        img.src = item.dataset.image;
        img.className = 'absolute w-16 h-16 cursor-move';
        img.style.left = `${e.clientX - canvas.getBoundingClientRect().left}px`;
        img.style.top = `${e.clientY - canvas.getBoundingClientRect().top}px`;
        img.dataset.id = id;
        canvas.appendChild(img);
    });

    // Save to Database
    document.getElementById('save-room').addEventListener('click', () => {
        const items = [];
        canvas.querySelectorAll('img').forEach(img => {
            items.push({
                id: img.dataset.id,
                x: parseInt(img.style.left),
                y: parseInt(img.style.top)
            });
        });

        fetch('{{ route("room.update") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
            body: JSON.stringify({ items })
        }).then(() => window.location.reload());
    });
</script>
@endsection