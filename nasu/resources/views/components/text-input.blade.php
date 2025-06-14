@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
    'class' => '
      px-3 border-0 
      border-b-[3px] border-accent
      rounded-none 
      focus:outline-none focus:ring-0 peer focus:border-accent
      bg-transparent
    '
  ]) }}>