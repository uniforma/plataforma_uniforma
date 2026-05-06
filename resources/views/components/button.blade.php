@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900 disabled:opacity-50 disabled:pointer-events-none rounded-md gap-2';
    
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'lg' => 'px-6 py-3 text-lg',
        default => 'px-4 py-2 text-sm',
    };

    $variantClasses = match($variant) {
        'secondary' => 'bg-white dark:bg-surface-800 border border-gray-300 dark:border-surface-900 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-surface-900 focus:ring-secondary-500',
        'danger' => 'bg-red-600 border border-transparent text-white hover:bg-red-700 focus:ring-red-500',
        'ghost' => 'bg-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-surface-900 hover:text-gray-900 dark:hover:text-gray-100 focus:ring-gray-500',
        'outline' => 'bg-transparent border border-primary-500 text-primary-500 dark:border-primary-400 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-gray-700 focus:ring-primary-500',
        'view' => 'bg-green-600 border border-transparent text-white hover:bg-green-700 focus:ring-green-500',
        'edit' => 'bg-blue-600 border border-transparent text-white hover:bg-blue-700 focus:ring-blue-500',
        default => 'bg-primary-500 border border-transparent text-white hover:bg-primary-600 focus:ring-primary-500 dark:bg-primary-400 dark:hover:bg-primary-500',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$baseClasses $sizeClasses $variantClasses"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$baseClasses $sizeClasses $variantClasses"]) }}>
        {{ $slot }}
    </button>
@endif