@props([
    'variant' => 'info',
])

@php
    $baseClasses = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium';

    $variantClasses = match($variant) {
        'success' => 'bg-green-100 text-green-800  ',
        'warning' => 'bg-yellow-100 text-yellow-800  ',
        'danger' => 'bg-red-100 text-red-800  ',
        'gray' => 'bg-gray-100 text-gray-800  ',
        default => 'bg-blue-100 text-blue-800  ', // info
    };
@endphp

<span {{ $attributes->merge(['class' => "$baseClasses $variantClasses"]) }}>
    {{ $slot }}
</span>
