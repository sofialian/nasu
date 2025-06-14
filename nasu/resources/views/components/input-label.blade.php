@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 font-body px-2
    absolute left-0 top-2 transition-all duration-200 pointer-events-none peer-placeholder-shown:text-base 
    peer-placeholder-shown:top-2 peer-focus:top-2 peer-focus:text-primary-dark peer-focus:text-sm 
    peer-focus:translate-y-[-12px] peer-focus:px-1']) }}>
    {{ $value ?? $slot }}
</label>
