@props(['value' => null])
@props(['value' => '', 'rows' => 10])

<textarea {!! $attributes->merge([
    'class' => 'w-full bg-transparent 
                border-l-4 border-secondary-color pl-10 py-2
                focus:border-accent focus:ring-0
                leading-relaxed resize-none',
    'rows' => $rows,
    'style' => 'background-image: linear-gradient(to bottom, transparent 95%, #e5e7eb 95%);
                background-size: 100% 1.5em;
                line-height: 1.5em'
]) !!}>{{ $value }}</textarea>