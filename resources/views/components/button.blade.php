@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 rounded-md font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-[#0B0B0B] disabled:pointer-events-none disabled:opacity-50';
    
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'lg' => 'px-6 py-3 text-lg',
        default => 'px-4 py-2 text-sm',
    };

    $variantClasses = match($variant) {
        'secondary' => 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-secondary-500 dark:border-white/10 dark:bg-surface-800 dark:text-gray-200 dark:hover:bg-[#3d443f]',
        'danger' => 'bg-red-600 border border-transparent text-white hover:bg-red-700 focus:ring-red-500',
        'ghost' => 'bg-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:ring-gray-500 dark:text-gray-300 dark:hover:bg-white/10 dark:hover:text-white',
        'outline' => 'bg-transparent border border-primary-500 text-primary-500 hover:bg-primary-50 focus:ring-primary-500 dark:border-primary-400 dark:text-primary-400 dark:hover:bg-white/10',
        'view' => 'border border-transparent bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500',
        'edit' => 'border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
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