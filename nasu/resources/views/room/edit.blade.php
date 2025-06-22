@extends('layouts.app')
@section('header', 'Editar habitación')
@section('content')
<div class="page mt-8 lg:p-6 rounded-lg shadow lg:max-w-7xl lg:mx-auto">
    <!-- Header with Actions -->
    <div class="flex justify-center items-start mb-6">
        <x-back-button class="" />
        <h1 class="flex-1 font-title">@yield('header')</h1>
    </div>
    <div class="flex flex-col justify-center items-center">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 w-2/3">
            <!-- Room Editor -->
            <div class="lg:col-span-2">
                <div class="room-editor bg-gray-50 rounded-lg border border-gray-200 relative overflow-hidden"
                    id="room-editor"
                    style="height: 60vh;
           width: 100%;      
           max-width: 60vh; 
           aspect-ratio: 1;  
                        background-image: linear-gradient(#e5e7eb 1px, transparent 1px),
                                        linear-gradient(90deg, #e5e7eb 1px, transparent 1px);
                        background-size: 20px 20px;">
                    @foreach($furnitureItems as $item)
                    @php
                    $viewImage = $viewImage = $item['views'][0]['image'] ?? $item['image'];


                    @endphp
                    <!-- <div class="furniture-item absolute cursor-move transition-transform duration-100"
                        data-item-id="{{ $item['id'] }}"
                        style="left: {{ $item['x'] }}px;
               top: {{ $item['y'] }}px;
               transform: rotate({{ $item['rotation'] }}deg); z-index: 1;"> -->
                    <div class="furniture-item absolute cursor-move transition-transform duration-100"
                        data-item-id="{{ $item['id'] }}"
                        data-rotation="{{ $item['rotation'] }}"
                        style="left: {{ $item['x'] }}px;
            top: {{ $item['y'] }}px;
            transform: rotate({{ $item['rotation'] }}deg); z-index: 1;">

                        <div class="relative">
                            <img src="{{ asset($viewImage) }}"
                                alt="{{ $item['name'] }}"
                                class="w-full h-auto object-contain shadow-sm rounded"
                                style="border: 2px solid white;">
                            <button class="remove-item absolute -top-2 -right-2 bg-accent text-primary-light rounded-full w-5 h-5 flex items-center justify-center hover:bg-red-600 transition-colors">
                                ×
                            </button>
                            <button class="rotate-btn absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-secondary-color/70 text-primary-dark rounded px-2 py-1 text-xs hover:bg-secondary-color transition-colors">
                                ↻
                            </button>
                        </div>
                    </div>
                    <pre>{{ $viewImage }}</pre>

                    @endforeach

                </div>
            </div>

            <!-- Available Furniture -->
            <div class="lg:col-span-1">
                <h3 class="font-body font-medium text-gray-700 mb-3">Muebles Disponibles</h3>
                <div class="available-furniture-container">
                    <div class="available-furniture-container mb-6 flex items-center gap-4">
                        <!-- Previous button (left side) -->
                        <button class="carousel-nav carousel-prev bg-white rounded-full p-2 shadow-md z-10 hidden md:flex items-center justify-center opacity-70 hover:opacity-100 transition-opacity"
                            style="flex: 0 0 auto;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Carousel container -->
                        <div class="available-furniture-carousel flex-1 relative overflow-hidden">
                            <!-- Scrolling container -->
                            <div class="available-furniture flex gap-4 overflow-x-auto pb-4 scroll-smooth snap-x snap-mandatory"
                                style="scrollbar-width: none; -ms-overflow-style: none;">
                                @forelse($availableFurniture as $item)
                                <div class="furniture-item flex-shrink-0 bg-gray-50 rounded-lg border border-gray-200 p-3 snap-start"
                                    data-user-furniture-id="{{ $item['user_furniture_id'] }}">
                                    <img src="{{ asset($item['image']) }}"
                                        class="w-full h-16 object-contain mx-auto mb-2">
                                    <p class="text-center text-sm font-medium text-gray-800 truncate">{{ $item['name'] }}</p>
                                    <button class="w-full mt-2 py-1 text-sm add-item border border-accent hover:bg-primary-700 text-primary-dark hover:border-2 transition-colors"
                                        data-furniture-id="{{ $item['furniture_id'] }}"
                                        data-user-furniture-id="{{ $item['user_furniture_id'] }}"
                                        data-image="{{ asset($item['image']) }}"
                                        data-name="{{ $item['name'] }}">
                                        Añadir
                                    </button>
                                </div>
                                @empty
                                <div class="col-span-full bg-gray-50 rounded-lg border border-gray-200 p-4 text-center w-full">
                                    <p class="text-gray-500">No furniture available</p>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Next button (right side) -->
                        <button class="carousel-nav carousel-next bg-white rounded-full p-2 shadow-md z-10 hidden md:flex items-center justify-center opacity-70 hover:opacity-100 transition-opacity"
                            style="flex: 0 0 auto;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div id="feedback" style="color: green; font-weight: bold;"></div>

                </div>
            </div>
        </div>
        <div class="flex justify-between items-center mt-6">
            <div class="flex gap-3">
                <!-- <a href="{{ route('dashboard', $room) }}">
                Cancelar
            </a> -->
                <x-primary-button id="save-changes">
                    Guardar Cambios
                </x-primary-button>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.rotate-btn').forEach(button => {
        button.addEventListener('click', () => {
            const container = button.closest('.furniture-item');
            const itemId = container.dataset.itemId;
            let rotation = parseInt(container.dataset.rotation || '0', 10);

            // Sumar 90 grados y resetear si llega a 360
            rotation = (rotation + 90) % 360;

            // Actualizar el dataset
            container.dataset.rotation = rotation;



            // Actualizar imagen vía fetch
            const img = container.querySelector('img');
            const feedback = document.getElementById('feedback');

            feedback.textContent = 'Cargando imagen rotada...';

            fetch(`/room-item/${itemId}/image/${rotation}`)
                .then(res => res.json())
                .then(data => {
                    if (data.image_url) {
                        img.src = data.image_url;
                        feedback.textContent = '✅ Imagen actualizada correctamente.';
                    } else {
                        feedback.textContent = '⚠️ No se encontró una imagen para esta rotación.';
                    }
                })
                .catch(err => {
                    console.error('Error al cargar imagen rotada:', err);
                    feedback.textContent = '❌ Error al cargar imagen rotada.';
                    alert(err);
                });

        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const saveButton = document.getElementById('save-changes');
        const roomEditor = document.getElementById('room-editor');
        const availableFurnitureContainer = document.querySelector('.available-furniture');

        // State management arrays
        let items = @json($furnitureItems);
        let removedItems = [];

        // Drag and drop state
        let draggedItem = null;
        let offsetX, offsetY;
        let isDragging = false;

        // --- UTILITY FUNCTIONS ---
        const snapToGrid = (value) => Math.round(value / 20) * 20;

        // --- EVENT LISTENERS ---

        // Save changes button
        saveButton.addEventListener('click', function() {
            if (isDragging) return; // Prevent saving while dragging

            saveButton.disabled = true;
            saveButton.innerHTML = `
                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                Guardando...
            `;

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

            fetch("{{ route('room.update-items', $room) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(result => {
                    if (result.success) {
                        window.location.href = result.redirect;
                    } else {
                        alert('Error al guardar cambios: ' + (result.message || 'Por favor verifique los datos.'));
                        console.error('Server errors:', result.errors);
                        saveButton.disabled = false;
                        saveButton.textContent = 'Guardar Cambios';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Ocurrió un error inesperado. Por favor, inténtelo de nuevo.');
                });

            function showError(message) {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3';
                alertDiv.style.zIndex = '1100';
                alertDiv.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                document.body.appendChild(alertDiv);

                setTimeout(() => {
                    alertDiv.classList.remove('show');
                    setTimeout(() => alertDiv.remove(), 150);
                }, 5000);

                saveButton.disabled = false;
                saveButton.innerHTML = `Guardar Cambios`;
            }
        });

        // Initialize all existing furniture items
        document.querySelectorAll('#room-editor .furniture-item').forEach(initFurnitureItem);

        // Initialize add buttons
        document.querySelectorAll('.add-item').forEach(button => {
            button.addEventListener('click', function() {
                const furnitureId = this.dataset.furnitureId;
                const userFurnitureId = this.dataset.userFurnitureId;
                const imageSrc = this.dataset.image;
                const itemName = this.dataset.name;

                // Create the new item element in the editor
                const roomRect = roomEditor.getBoundingClientRect();
                const centerX = snapToGrid(roomRect.width / 2 - 50);
                const centerY = snapToGrid(roomRect.height / 2 - 50);

                const newItemEl = document.createElement('div');
                newItemEl.className = 'furniture-item absolute cursor-move transition-transform duration-100';
                newItemEl.dataset.itemId = 'new-' + Date.now();
                newItemEl.style.left = centerX + 'px';
                newItemEl.style.top = centerY + 'px';
                newItemEl.style.transform = 'rotate(0deg)';
                newItemEl.style.width = '100px';
                newItemEl.style.zIndex = '1';
                newItemEl.innerHTML = `
                    <div class="relative">
                        <img src="${imageSrc}" alt="${itemName}" class="w-full h-auto object-contain shadow-sm rounded" style="border: 2px solid white;">
                        <button class="remove-item absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center hover:bg-red-600 transition-colors">
                            ×
                        </button>
                        <button class="rotate-btn absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-secondary-color/70 text-primary-dark rounded px-2 py-1 text-xs hover:bg-secondary-color transition-colors">
                                ↻
                        </button>
                    </div>
                `;
                roomEditor.appendChild(newItemEl);

                // Add the new item's data to our state array
                items.push({
                    id: newItemEl.dataset.itemId,
                    furniture_id: furnitureId,
                    user_furniture_id: userFurnitureId,
                    x: centerX,
                    y: centerY,
                    rotation: 0,
                    is_new: true,
                    name: itemName,
                    image: imageSrc
                });

                // Make the new item interactive
                initFurnitureItem(newItemEl);

                // Hide the item in available furniture
                const availableItem = document.querySelector(`.furniture-item[data-user-furniture-id="${userFurnitureId}"]`);
                if (availableItem) {
                    availableItem.style.display = 'none';
                }
            });
        });

        // Initialize furniture item with drag, rotate, and remove functionality
        function initFurnitureItem(item) {
            const itemId = item.dataset.itemId;

            // Drag start handler
            item.addEventListener('mousedown', function(e) {
                if (e.target.classList.contains('remove-item') ||
                    e.target.classList.contains('rotate-btn') ||
                    e.target.tagName === 'svg' ||
                    e.target.tagName === 'path') {
                    return;
                }

                isDragging = true;
                draggedItem = this;
                const rect = this.getBoundingClientRect();
                offsetX = e.clientX - rect.left;
                offsetY = e.clientY - rect.top;

                this.style.transition = 'none';
                this.style.zIndex = '1000';
                this.querySelector('img').style.boxShadow = '0 0 10px rgba(0,0,0,0.3)';

                document.addEventListener('mousemove', moveItem);
                document.addEventListener('mouseup', stopDrag);
                e.preventDefault();
            });


            //Rotate handler
            

            // Removal handler
            item.querySelector('.remove-item')?.addEventListener('click', function(e) {
                e.stopPropagation();
                const itemIndex = items.findIndex(i => i.id == itemId);

                if (itemIndex !== -1) {
                    const itemData = items[itemIndex];

                    if (!itemData.is_new) {
                        // For existing items, mark for removal
                        removedItems.push(itemData.id);

                        // Show it again in available furniture
                        const existingAvailableItem = document.querySelector(`.furniture-item[data-user-furniture-id="${itemData.user_furniture_id}"]`);
                        if (existingAvailableItem) {
                            existingAvailableItem.style.display = 'block';
                        } else {
                            // Create new available item if not found
                            const newAvailableItem = document.createElement('div');
                            newAvailableItem.className = 'furniture-item bg-gray-50 rounded-lg border border-gray-200 p-3 hover:shadow-md transition-shadow';
                            newAvailableItem.dataset.userFurnitureId = itemData.user_furniture_id;
                            newAvailableItem.innerHTML = `
                                <img src="${itemData.image}" class="w-full h-16 object-contain mx-auto mb-2">
                                <p class="text-center text-sm font-medium text-gray-800 truncate">${itemData.name}</p>
                                <button class="w-full mt-2 py-1 text-sm add-item"
                                    data-furniture-id="${itemData.furniture_id}"
                                    data-user-furniture-id="${itemData.user_furniture_id}"
                                    data-image="${itemData.image}"
                                    data-name="${itemData.name}">
                                    Añadir
                                </button>
                            `;
                            availableFurnitureContainer.appendChild(newAvailableItem);

                            // Add event listener to the new button
                            newAvailableItem.querySelector('.add-item').addEventListener('click', function() {
                                const furnitureId = this.dataset.furnitureId;
                                const userFurnitureId = this.dataset.userFurnitureId;
                                const imageSrc = this.dataset.image;
                                const itemName = this.dataset.name;

                                const roomRect = roomEditor.getBoundingClientRect();
                                const centerX = snapToGrid(roomRect.width / 2 - 50);
                                const centerY = snapToGrid(roomRect.height / 2 - 50);

                                const newItemEl = document.createElement('div');
                                newItemEl.className = 'furniture-item absolute cursor-move transition-transform duration-100';
                                newItemEl.dataset.itemId = 'new-' + Date.now();
                                newItemEl.style.left = centerX + 'px';
                                newItemEl.style.top = centerY + 'px';
                                newItemEl.style.transform = 'rotate(0deg)';
                                newItemEl.style.width = '100px';
                                newItemEl.style.zIndex = '1';
                                newItemEl.innerHTML = `
                                    <div class="relative">
                                        <img src="${imageSrc}" alt="${itemName}" class="w-full h-auto object-contain shadow-sm rounded" style="border: 2px solid white;">
                                        <button class="remove-item absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center hover:bg-red-600 transition-colors">
                                            ×
                                        </button>
                                        <button class="rotate-btn absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-secondary-color/70 text-primary-dark rounded px-2 py-1 text-xs hover:bg-secondary-color transition-colors">
                                         ↻
                                        </button>
                                    </div>
                                `;
                                roomEditor.appendChild(newItemEl);

                                items.push({
                                    id: newItemEl.dataset.itemId,
                                    furniture_id: furnitureId,
                                    user_furniture_id: userFurnitureId,
                                    x: centerX,
                                    y: centerY,
                                    rotation: 0,
                                    is_new: true,
                                    name: itemName,
                                    image: imageSrc
                                });

                                initFurnitureItem(newItemEl);
                                this.closest('.furniture-item').style.display = 'none';
                            });
                        }
                    } else {
                        // For new items, just show the available furniture again
                        const availableItem = document.querySelector(`.furniture-item[data-user-furniture-id="${itemData.user_furniture_id}"]`);
                        if (availableItem) {
                            availableItem.style.display = 'block';
                        }
                    }

                    // Remove from items array
                    items.splice(itemIndex, 1);
                }

                // Remove from DOM
                item.remove();
            });
        }

        // Item dragging handler
        function moveItem(e) {
            if (!draggedItem) return;

            const roomRect = roomEditor.getBoundingClientRect();
            let x = e.clientX - roomRect.left - offsetX;
            let y = e.clientY - roomRect.top - offsetY;

            const maxX = roomRect.width - draggedItem.offsetWidth;
            const maxY = roomRect.height - draggedItem.offsetHeight;

            // Snap to grid and constrain to room bounds
            x = snapToGrid(Math.max(0, Math.min(x, roomRect.width - draggedItem.offsetWidth)));
            y = snapToGrid(Math.max(0, Math.min(y, roomRect.height - draggedItem.offsetHeight)));

            // Update position
            draggedItem.style.left = `${x}px`;
            draggedItem.style.top = `${y}px`;
        }

        // Drag end handler
        function stopDrag() {
            if (draggedItem) {
                const itemId = draggedItem.dataset.itemId;
                const itemIndex = items.findIndex(i => i.id == itemId);

                if (itemIndex !== -1) {
                    // Update state with new position
                    items[itemIndex].x = parseInt(draggedItem.style.left);
                    items[itemIndex].y = parseInt(draggedItem.style.top);
                }

                // Reset styles
                draggedItem.style.transition = 'all 0.3s ease';
                draggedItem.style.zIndex = '1';
                draggedItem.querySelector('img').style.boxShadow = '';
            }

            // Reset drag state
            draggedItem = null;
            isDragging = false;
            document.removeEventListener('mousemove', moveItem);
            document.removeEventListener('mouseup', stopDrag);
        }

        // Prevent save while dragging
        document.addEventListener('mousemove', function() {
            if (isDragging) {
                saveButton.disabled = true;
                saveButton.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                saveButton.disabled = false;
                saveButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        });
    });
</script>
@endpush


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.querySelector('.available-furniture');
        const prevBtn = document.querySelector('.carousel-prev');
        const nextBtn = document.querySelector('.carousel-next');

        // Update button visibility based on scroll position
        function updateNavButtons() {
            const isAtStart = carousel.scrollLeft <= 10;
            const isAtEnd = carousel.scrollLeft >= (carousel.scrollWidth - carousel.clientWidth - 10);

            prevBtn.classList.toggle('hidden', isAtStart);
            nextBtn.classList.toggle('hidden', isAtEnd);
        }

        // Navigation button event listeners
        prevBtn.addEventListener('click', () => {
            carousel.scrollBy({
                left: -200,
                behavior: 'smooth'
            });
        });

        nextBtn.addEventListener('click', () => {
            carousel.scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        });

        // Initialize and update on scroll
        updateNavButtons();
        carousel.addEventListener('scroll', updateNavButtons);

        // Handle window resize
        window.addEventListener('resize', updateNavButtons);
    });
</script>
@endpush

@push('styles')
<style>
    /* Hide scrollbar but keep functionality */
    .available-furniture::-webkit-scrollbar {
        display: none;
    }

    /* Carousel item styling */
    .furniture-item {
        scroll-snap-align: start;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {
        .furniture-item {
            width: 140px;
        }
    }
</style>
@endpush