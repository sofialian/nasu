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
                        data-furniture-id="{{ $item['furniture_id'] }}"
                        data-user-furniture-id="{{ $item['user_furniture_id'] }}">
                        Add to Room
                    </button>
                </div>
                @empty
                <p>No available furniture</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const saveButton = document.getElementById('save-changes');
    const roomEditor = document.getElementById('room-editor');

    // State management arrays
    let items = @json($furnitureItems);
    let removedItems = [];

    // Drag and drop state
    let draggedItem = null;
    let offsetX, offsetY;

    // --- UTILITY ---
    const snapToGrid = (value) => Math.round(value / 20) * 20;

    // --- EVENT LISTENERS ---

    // Save changes button
    saveButton.addEventListener('click', function() {
        saveButton.disabled = true;
        saveButton.textContent = 'Saving...';

        // Prepare the data payload for the server
        const data = {
            _token: '{{ csrf_token() }}',
            _method: 'PUT',
            items: items.filter(item => !item.is_new).map(item => ({
                id: item.id,
                x: item.x,
                y: item.y,
                rotation: item.rotation
            })),
            new_items: items.filter(item => item.is_new).map(item => ({
                furniture_id: item.furniture_id,
                user_furniture_id: item.user_furniture_id,
                x: item.x,
                y: item.y,
                rotation: item.rotation
            })),
            removed_items: removedItems
        };

        console.log("Data being sent:", JSON.stringify(data, null, 2));

        fetch("{{ route('room.update-items', $room) }}", {
            method: 'POST', // Method is POST to tunnel PUT
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                window.location.href = result.redirect;
            } else {
                alert('Failed to save changes: ' + (result.message || 'Please check the data.'));
                console.error('Server errors:', result.errors);
                saveButton.disabled = false;
                saveButton.textContent = 'Save Changes';
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            alert('An unexpected network error occurred. Please try again.');
            saveButton.disabled = false;
            saveButton.textContent = 'Save Changes';
        });
    });

    // "Add to Room" buttons for available furniture
    document.querySelectorAll('.add-item').forEach(button => {
        button.addEventListener('click', function() {
            const furnitureData = this.closest('.furniture-item');
            const imageSrc = furnitureData.querySelector('img').src;
            const itemName = furnitureData.querySelector('p').textContent;
            
            // Create the new item element in the editor
            const roomRect = roomEditor.getBoundingClientRect();
            const centerX = snapToGrid(roomRect.width / 2 - 50);
            const centerY = snapToGrid(roomRect.height / 2 - 50);

            const newItemEl = document.createElement('div');
            newItemEl.className = 'furniture-item';
            newItemEl.dataset.itemId = 'new-' + Date.now(); // Unique temporary ID
            newItemEl.style.position = 'absolute';
            newItemEl.style.left = centerX + 'px';
            newItemEl.style.top = centerY + 'px';
            newItemEl.style.transform = 'rotate(0deg)';
            newItemEl.style.cursor = 'move';
            newItemEl.style.width = '100px';
            newItemEl.innerHTML = `
                <img src="${imageSrc}" alt="${itemName}" style="width: 100%; height: auto;">
                <button class="btn btn-sm btn-danger remove-item" style="position: absolute; top: -10px; right: -10px;">×</button>
                <button class="btn btn-sm btn-outline-secondary rotate-btn" style="position: absolute; bottom: -30px; left: 50%; transform: translateX(-50%);">↻ Rotate</button>
            `;
            roomEditor.appendChild(newItemEl);
            
            // Add the new item's data to our state array
            items.push({
                id: newItemEl.dataset.itemId,
                furniture_id: this.dataset.furnitureId,
                user_furniture_id: this.dataset.userFurnitureId,
                x: centerX,
                y: centerY,
                rotation: 0,
                is_new: true // Flag to identify it as a new item
            });

            // Make the new item interactive
            initFurnitureItem(newItemEl);
            
            // Hide the button in the "Available Furniture" list to prevent duplicates
            furnitureData.style.display = 'none';
        });
    });

    // --- INITIALIZATION ---

    // Main function to make an item interactive (drag, rotate, remove)
    function initFurnitureItem(item) {
        const itemId = item.dataset.itemId;

        // Drag start
        item.addEventListener('mousedown', function(e) {
            if (e.target.classList.contains('remove-item') || e.target.classList.contains('rotate-btn')) return;
            
            draggedItem = this;
            const rect = this.getBoundingClientRect();
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;
            
            this.style.transition = 'none';
            this.style.zIndex = '1000';

            document.addEventListener('mousemove', moveItem);
            document.addEventListener('mouseup', stopDrag);
            e.preventDefault();
        });

        // Rotation
        item.querySelector('.rotate-btn')?.addEventListener('click', function(e) {
            e.stopPropagation();
            const currentRotation = parseInt(item.style.transform.match(/rotate\((\d+)deg\)/)?.[1] || 0);
            const newRotation = (currentRotation + 90) % 360;
            item.style.transform = `rotate(${newRotation}deg)`;

            const itemIndex = items.findIndex(i => i.id == itemId);
            if (itemIndex !== -1) items[itemIndex].rotation = newRotation;
        });

        // Removal
        item.querySelector('.remove-item')?.addEventListener('click', function(e) {
            e.stopPropagation();
            const itemIndex = items.findIndex(i => i.id == itemId);

            if (itemIndex !== -1) {
                const itemData = items[itemIndex];
                if (!itemData.is_new) {
                    // If it's an existing item, add its ID to the removed list
                    removedItems.push(itemData.id);
                } else {
                    // If it was a new item, re-display it in the "Available" list
                    const addButton = document.querySelector(`.add-item[data-user-furniture-id='${itemData.user_furniture_id}']`);
                    if (addButton) addButton.closest('.furniture-item').style.display = 'block';
                }
                // Remove from the main state array
                items.splice(itemIndex, 1);
            }
            // Remove from the DOM
            item.remove();
        });
    }

    // Drag move handler
    function moveItem(e) {
        if (!draggedItem) return;

        const roomRect = roomEditor.getBoundingClientRect();
        let x = e.clientX - roomRect.left - offsetX;
        let y = e.clientY - roomRect.top - offsetY;

        x = snapToGrid(x);
        y = snapToGrid(y);

        // Constrain to bounds
        x = Math.max(0, Math.min(x, roomRect.width - draggedItem.offsetWidth));
        y = Math.max(0, Math.min(y, roomRect.height - draggedItem.offsetHeight));

        draggedItem.style.left = `${x}px`;
        draggedItem.style.top = `${y}px`;
    }

    // Drag stop handler
    function stopDrag() {
        if (draggedItem) {
            const itemId = draggedItem.dataset.itemId;
            const itemIndex = items.findIndex(i => i.id == itemId);
            if (itemIndex !== -1) {
                items[itemIndex].x = parseInt(draggedItem.style.left);
                items[itemIndex].y = parseInt(draggedItem.style.top);
            }

            draggedItem.style.transition = 'all 0.3s ease';
            draggedItem.style.zIndex = '';
        }

        draggedItem = null;
        document.removeEventListener('mousemove', moveItem);
        document.removeEventListener('mouseup', stopDrag);
    }

    // Initialize all furniture items already present in the room on page load
    document.querySelectorAll('#room-editor .furniture-item').forEach(initFurnitureItem);
});
</script>
@endpush