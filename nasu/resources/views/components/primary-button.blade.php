<button 
  {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'border-2 border-accent bg-accent shadow hover:opacity-70
     text-primary-light py-3 px-8 transition duration-300 w-full text-base md:text-lg'
  ]) }}
>
  {{ $slot }}
</button>
