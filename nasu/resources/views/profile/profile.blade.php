<div class="user-profile">
    <h1>{{ $user->name }}'s Profile</h1>

    <div class="user-stats">
        <p>Beans: {{ $user->balance->beans }}</p>
        <p>Furniture Owned: {{ $user->ownedFurniture->count() }}</p>
    </div>

    <div class="room-preview">
        <h2>Your Room</h2>
        @foreach($user->room->items as $item)
        <div class="mini-furniture">
            <img src="{{ asset($item->furniture->image_path) }}"
                alt="{{ $item->furniture->name }}"
                width="50">
        </div>
        @endforeach
    </div>
</div>