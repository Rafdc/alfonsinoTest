@props([
    'for',
    'type' => 'text'
])

<input type="{{ $type }}" 
        @error($for) 
            {{ $attributes->merge(['class' => 'form-control is-invalid']) }} 
        @else 
            {{ $attributes->merge(['class' => 'form-control']) }} 
        @enderror  
        id="{{ $for }}" 
        name="{{ $for }}"
        >