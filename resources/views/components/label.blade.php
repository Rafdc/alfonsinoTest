@props([
    'for'
])

<label {{ $attributes->merge(['class' => 'text-primary']) }} for="{{ $for }}">{{ $slot }}</label>