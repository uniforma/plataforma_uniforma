@props([
    'align' => 'left'
])

@php
    $alignmentClass = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };
@endphp

<td {{ $attributes->merge(['class' => "px-6 py-4 whitespace-nowrap align-middle $alignmentClass"]) }}>
    {{ $slot }}
</td>