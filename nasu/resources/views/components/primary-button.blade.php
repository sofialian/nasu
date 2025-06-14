<button 
  {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'bg-accent shadow hover:opacity-70
     text-primary-light font-semibold py-3 px-8 transition duration-300 mb-4 w-full text-base md:text-lg'
  ]) }}
>
  {{ $slot }}
</button>
