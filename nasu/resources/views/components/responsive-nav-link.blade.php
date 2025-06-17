@props(['active'])

@php
$classes = ($active ?? false)
? 'block w-full ps-3 pe-4 py-2 text-start text-4xl font-medium font-title 
uppercase text-accent focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 
focus:border-indigo-700 transition duration-150 ease-in-out flex items-center'
: 'block w-full ps-3 pe-4 py-2 text-start text-4xl 
font-medium font-title text-primary-dark uppercase
hover:border-b-2 hover:border-accent
focus:outline-none focus:border-b-2 focus:border-accent  transition 
duration-150 ease-in-out flex items-center';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="flex">
        {{ $slot }}
    </span>
    @if ($active)
    <div class="ml-2 w-2 h-2 bg-accent rounded-full"></div>
    @endif
</a>