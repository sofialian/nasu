@props(['checked' => false, 'id' => null, 'name' => null])

<input 
    type="checkbox" 
    id="{{ $id }}" 
    name="{{ $name }}" 
    @checked($checked)
    {{ $attributes->merge([
        'class' => ' border-2 focus:ring-1 focus:ring-offset-1 focus:ring-primary ' . 
                  ($checked ? '' : 'bg-transparent border-secondary-color')
    ]) }} 
/>
