@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Room Display -->
        <div class="col-md-8">
            <div class="room-display"
                style="position: relative; 
                        height: 500px; 
                        border: 1px solid #ccc;
                        background-color: #f5f5f5;">
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
                    <div class="item-name">{{ $item['name'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Available Furniture -->
        <div class="col-md-4">
            <h3>Available Furniture</h3>
            <div class="available-furniture" style="display: flex; flex-wrap: wrap; gap: 10px;">
                @forelse($availableFurniture as $furniture)
                <div class="furniture-item draggable"
                    data-furniture-id="{{ $furniture->id }}"
                    style="padding: 10px; 
                                border: 1px solid #ddd;
                                border-radius: 5px;
                                cursor: grab;">
                    <img src="{{ asset($furniture->image_path) }}"
                        alt="{{ $furniture->name }}"
                        style="width: 80px; height: auto;">
                    <p style="margin-top: 5px; text-align: center;">{{ $furniture->name }}</p>
                </div>
                @empty
                <p>No available furniture to add.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const room = document.querySelector('.room-display');
        const draggables = document.querySelectorAll('.draggable');

        draggables.forEach(draggable => {
            draggable.addEventListener('dragstart', () => {
                draggable.classList.add('dragging');
            });

            draggable.addEventListener('dragend', () => {
                draggable.classList.remove('dragging');
            });
        });

        room.addEventListener('dragover', e => {
            e.preventDefault();
            room.style.backgroundColor = '#e9e9e9';
        });

        room.addEventListener('dragleave', () => {
            room.style.backgroundColor = '#f5f5f5';
        });

        room.addEventListener('drop', e => {
            e.preventDefault();
            room.style.backgroundColor = '#f5f5f5';

            const draggingElement = document.querySelector('.dragging');
            if (!draggingElement) return;

            const furnitureId = draggingElement.dataset.furnitureId;
            const rect = room.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            // Use Laravel's route helper
            fetch("{{ route('rooms.place', $room->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        furniture_id: furnitureId,
                        x_position: x,
                        y_position: y,
                        rotation: 0
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Failed to place item');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to place furniture: ' + error.message);
                });
        });
    });
</script>
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
@endpush
@endsection