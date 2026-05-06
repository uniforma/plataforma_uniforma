<div {{ $attributes->merge(['class' => 'relative flex items-center py-4']) }}>
    <div class="flex-grow border-t border-gray-300 dark:border-gray-500"></div>
    
    @if($slot->isNotEmpty())
        <span class="flex-shrink-0 mx-4 text-sm font-medium text-gray-500 dark:text-gray-300">
            {{ $slot }}
        </span>
    @endif
    
    <div class="flex-grow border-t border-gray-300 dark:border-gray-500"></div>
</div>