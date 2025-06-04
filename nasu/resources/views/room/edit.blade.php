@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h1>Edit Room Layout</h1>
        <div>
            <a href="{{ route('room.show', $room) }}" class="btn btn-secondary">Cancel</a>
            <button id="save-changes" class="btn btn-primary">Save Changes</button>
        </div>
    </div>

    <div class="row">
        <!-- Room Editor -->
        <div class="col-md-8">
            <div class="room-editor" id="room-editor"
                style="position: relative; 
                       height: 500px; 
                       border: 1px solid #ccc; 
                       background-color: #f5f5f5;
                       background-image: linear-gradient(#ccc 1px, transparent 1px),
                                       linear-gradient(90deg, #ccc 1px, transparent 1px);
                       background-size: 20px 20px;">
                @foreach($furnitureItems as $item)
                <div class="furniture-item"
                    data-item-id="{{ $item['id'] }}"
                    style="position: absolute;
                           left: {{ $item['x'] }}px;
                           top: {{ $item['y'] }}px;
                           transform: rotate({{ $item['rotation'] }}deg);
                           cursor: move;
                           width: 100px;">
                    <img src="{{ asset($item['image']) }}"
                        alt="{{ $item['name'] }}"
                        style="width: 100%; height: auto;">
                    <button class="btn btn-sm btn-danger remove-item"
                        style="position: absolute; top: -10px; right: -10px;">
                        ×
                    </button>
                    <button class="btn btn-sm btn-outline-secondary rotate-btn"
                        style="position: absolute; bottom: -30px; left: 50%; transform: translateX(-50%);">
                        ↻ Rotate
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Available Furniture -->
        <div class="col-md-4">
            <h3>Available Furniture</h3>
            <div class="available-furniture" style="display: flex; flex-wrap: wrap; gap: 10px;">
                @forelse($availableFurniture as $item)
                <div class="furniture-item" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                    <img src="{{ asset($item['image']) }}" style="width: 80px; height: auto;">
                    <p style="text-align: center;">{{ $item['name'] }}</p>
                    <button class="btn btn-sm btn-primary mt-2 add-item"
                        data-furniture-id="{{ $item['id'] }}">
                        Add to Room
                    </button>
                </div>
                @empty
                <p>No available furniture</p>
                @endforelse
            </div>
        </div>
    </div>

    <form id="room-edit-form" action="{{ route('rooms.update-items', $room) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="items" id="items-data">
        <input type="hidden" name="removed_items" id="removed-items-data">
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('room-edit-form');
    const itemsInput = document.getElementById('items-data');
    const removedItemsInput = document.getElementById('removed-items-data');
    const saveButton = document.getElementById('save-changes');
    const roomEditor = document.getElementById('room-editor');

    let items = @json($furnitureItems);
    let removedItems = [];
    let draggedItem = null;
    let offsetX, offsetY;

    // Snap to grid function (20px grid)
    function snapToGrid(value) {
        const gridSize = 20;
        return Math.round(value / gridSize) * gridSize;
    }

    // Add to Room functionality
    document.querySelectorAll('.add-item').forEach(button => {
        button.addEventListener('click', function() {
            const furnitureId = this.dataset.furnitureId;
            const furnitureItem = this.closest('.furniture-item');
            const imageSrc = furnitureItem.querySelector('img').src;
            const itemName = furnitureItem.querySelector('p').textContent;

            // Create new item in the center of the room
            const roomRect = roomEditor.getBoundingClientRect();
            const centerX = Math.round(roomRect.width / 2 / 20) * 20 - 50; // Centered and snapped to grid
            const centerY = Math.round(roomRect.height / 2 / 20) * 20 - 50;

            const newItem = document.createElement('div');
            newItem.className = 'furniture-item';
            newItem.dataset.itemId = 'new-' + Date.now();
            newItem.style.position = 'absolute';
            newItem.style.left = centerX + 'px';
            newItem.style.top = centerY + 'px';
            newItem.style.transform = 'rotate(0deg)';
            newItem.style.cursor = 'move';
            newItem.style.width = '100px';
            
            newItem.innerHTML = `
                <img src="${imageSrc}" style="width: 100%; height: auto;">
                <button class="btn btn-sm btn-danger remove-item"
                    style="position: absolute; top: -10px; right: -10px;">×</button>
                <button class="btn btn-sm btn-outline-secondary rotate-btn"
                    style="position: absolute; bottom: -30px; left: 50%; transform: translateX(-50%);">
                    ↻ Rotate
                </button>
            `;

            roomEditor.appendChild(newItem);

            // Add to items array
            items.push({
                id: newItem.dataset.itemId,
                furniture_id: furnitureId,
                name: itemName,
                image: imageSrc.replace(window.location.origin, ''),
                x: centerX,
                y: centerY,
                rotation: 0,
                is_new: true
            });

            // Initialize event listeners for the new item
            initFurnitureItem(newItem);
        });
    });

    function initFurnitureItem(item) {
        const itemId = item.dataset.itemId;

        // Setup drag
        item.addEventListener('mousedown', function(e) {
            if (e.target.classList.contains('remove-item') ||
                e.target.classList.contains('rotate-btn')) return;

            draggedItem = this;
            offsetX = e.clientX - this.getBoundingClientRect().left;
            offsetY = e.clientY - this.getBoundingClientRect().top;

            this.style.transition = 'none';
            this.style.zIndex = '1000';

            document.addEventListener('mousemove', moveItem);
            document.addEventListener('mouseup', stopDrag);
        });

        // Setup rotation
        item.querySelector('.rotate-btn').addEventListener('click', function(e) {
            e.stopPropagation();
            const currentRotation = parseInt(item.style.transform.match(/rotate\((\d+)deg\)/)[1]) || 0;
            const newRotation = (currentRotation + 90) % 360;
            item.style.transform = `rotate(${newRotation}deg)`;

            // Update in items array
            const itemIndex = items.findIndex(i => i.id === itemId);
            if (itemIndex !== -1) {
                items[itemIndex].rotation = newRotation;
            }
        });

        // Setup remove button
        item.querySelector('.remove-item').addEventListener('click', function(e) {
            e.stopPropagation();
            removedItems.push(itemId);
            item.remove();

            // Remove from items array
            items = items.filter(i => i.id !== itemId);
        });
    }

    // Initialize existing items
    document.querySelectorAll('#room-editor .furniture-item').forEach(initFurnitureItem);

    function moveItem(e) {
        if (!draggedItem) return;

        const roomRect = roomEditor.getBoundingClientRect();
        let x = e.clientX - roomRect.left - offsetX;
        let y = e.clientY - roomRect.top - offsetY;

        // Snap to grid
        x = snapToGrid(x);
        y = snapToGrid(y);

        // Keep within bounds
        x = Math.max(0, Math.min(x, roomRect.width - draggedItem.offsetWidth));
        y = Math.max(0, Math.min(y, roomRect.height - draggedItem.offsetHeight));

        draggedItem.style.left = `${x}px`;
        draggedItem.style.top = `${y}px`;
    }

    function stopDrag() {
        document.removeEventListener('mousemove', moveItem);
        document.removeEventListener('mouseup', stopDrag);

        if (draggedItem) {
            const itemId = draggedItem.dataset.itemId;
            const itemIndex = items.findIndex(i => i.id === itemId);

            if (itemIndex !== -1) {
                items[itemIndex].x = parseInt(draggedItem.style.left);
                items[itemIndex].y = parseInt(draggedItem.style.top);
            }

            draggedItem.style.transition = 'all 0.3s ease';
            draggedItem.style.zIndex = '';
        }

        draggedItem = null;
    }

    // Save changes
    saveButton.addEventListener('click', function() {
        // Disable button during save
        saveButton.disabled = true;
        saveButton.textContent = 'Saving...';

        // Prepare form data
        const formData = new FormData(form);
        formData.set('items', JSON.stringify(items));
        formData.set('removed_items', JSON.stringify(removedItems));

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect || "{{ route('room.show', $room) }}";
            } else {
                alert(data.message || 'Changes saved successfully!');
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving changes: ' + (error.message || 'Please try again'));
            saveButton.disabled = false;
            saveButton.textContent = 'Save Changes';
        });
    });
});
</script>
@endpush