<button onclick="history.back()" {{ $attributes->merge(['class' => 'flex items-center text-gray-600 hover:text-accent transition-colors']) }}>
    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    {{ $slot ?? 'Volver' }}
</button>