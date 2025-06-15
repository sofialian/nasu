<button {{ $attributes->merge(['type' => 'button', 'class' => 'border-2 border-accent 
    shadow hover:bg-accent hover:text-primary-light text-primary-dark py-3 
    px-8 transition duration-300 w-full text-base md:text-lg']) }}>
    {{ $slot }}
</button>
