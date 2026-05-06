<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden']) }}>
    @if(isset($header))
        <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $header }}
        </div>
    @endif

    <div class="px-4 py-5 sm:p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-4 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $footer }}
        </div>
    @endif
</div>