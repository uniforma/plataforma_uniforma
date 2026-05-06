@props([
    'sortable' => false,
    'direction' => null, // 'asc', 'desc', or null
    'align' => 'left' // 'left', 'center', 'right'
])

@php
    $alignmentClass = match($align) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };
@endphp

<th {{ $attributes->merge(['class' => "px-6 py-3 font-semibold uppercase tracking-wider whitespace-nowrap select-none $alignmentClass"]) }}>
    @if($sortable)
        <button type="button" class="group inline-flex items-center space-x-1 focus:outline-none w-full {{ $alignmentClass == 'text-center' ? 'justify-center' : ($alignmentClass == 'text-right' ? 'justify-end' : 'justify-start') }}">
            <span>{{ $slot }}</span>
            <span class="relative flex items-center">
                @if($direction === 'asc')
                    <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                @elseif($direction === 'desc')
                    <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @else
                    <svg class="h-4 w-4 text-gray-300 dark:text-gray-600 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                    </svg>
                @endif
            </span>
        </button>
    @else
        {{ $slot }}
    @endif
</th>