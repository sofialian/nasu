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
                @forelse($availableFurniture as $furniture)
                <div class="furniture-item draggable"
                    data-furniture-id="{{ $furniture->id }}"
                    style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; cursor: grab;">
                    <img src="{{ asset($furniture->image_path) }}"
                        style="width: 80px; height: auto;">
                    <p style="text-align: center;">{{ $furniture->name }}</p>
                </div>
                @empty
                <p>No available furniture to add.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<form id="room-edit-form" action="{{ route('rooms.update-items', $room) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="items" id="items-data">
    <input type="hidden" name="removed_items" id="removed-items-data">
</form>

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

    // Initialize items
    document.querySelectorAll('#room-editor .furniture-item').forEach(item => {
        const itemId = parseInt(item.dataset.itemId);
        
        // Setup drag with smooth movement
        item.addEventListener('mousedown', function(e) {
            if (e.target.classList.contains('remove-item') || 
                e.target.classList.contains('rotate-btn')) return;
            
            draggedItem = this;
            offsetX = e.clientX - this.getBoundingClientRect().left;
            offsetY = e.clientY - this.getBoundingClientRect().top;
            
            // Add smooth transition during drag
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
    });

    function moveItem(e) {
        if (!draggedItem) return;
        
        const roomRect = roomEditor.getBoundingClientRect();
        let x = e.clientX - roomRect.left - offsetX;
        let y = e.clientY - roomRect.top - offsetY;
        
        // Snap to grid while dragging (for precise placement)
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
            const itemId = parseInt(draggedItem.dataset.itemId);
            const itemIndex = items.findIndex(i => i.id === itemId);
            
            if (itemIndex !== -1) {
                items[itemIndex].x = parseInt(draggedItem.style.left);
                items[itemIndex].y = parseInt(draggedItem.style.top);
            }
            
            // Restore transition and z-index
            draggedItem.style.transition = 'all 0.3s ease';
            draggedItem.style.zIndex = '';
        }
        
        draggedItem = null;
    }

    // Save changes with proper error handling
    saveButton.addEventListener('click', function() {
        // Update all positions before saving
        document.querySelectorAll('#room-editor .furniture-item').forEach(item => {
            const itemId = parseInt(item.dataset.itemId);
            const itemIndex = items.findIndex(i => i.id === itemId);
            
            if (itemIndex !== -1) {
                items[itemIndex].x = parseInt(item.style.left);
                items[itemIndex].y = parseInt(item.style.top);
                const rotationMatch = item.style.transform.match(/rotate\((\d+)deg\)/);
                items[itemIndex].rotation = rotationMatch ? parseInt(rotationMatch[1]) : 0;
            }
        });
        
        // Prepare form data (using FormData for proper Laravel handling)
        const formData = new FormData(form);
        formData.set('items', JSON.stringify(items));
        formData.set('removed_items', JSON.stringify(removedItems));
        
        // Add proper headers
        const headers = {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        };
        
        // Submit form via AJAX
        fetch(form.action, {
            method: 'POST',
            headers: headers,
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success && data.redirect) {
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'Changes saved successfully!');
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error: ' + (error.message || 'Failed to save changes'));
        });
    });
});
</script>
@endpush
@endsection