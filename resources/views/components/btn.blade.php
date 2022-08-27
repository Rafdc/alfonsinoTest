@props([
    'href',
    'typeBtn'
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-'.$typeBtn ]) }}>{{ $slot }}</a>