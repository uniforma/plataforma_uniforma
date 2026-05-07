<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm dark:border-white/5 dark:bg-surface-800']) }}>
    @if(isset($header))
        <div class="border-b border-gray-200 px-4 py-4 sm:px-6 dark:border-white/5">
            {{ $header }}
        </div>
    @endif

    <div class="px-4 py-5 sm:p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="border-t border-gray-200 bg-gray-50 px-4 py-4 sm:px-6 dark:border-white/5 dark:bg-[#2b302d]">
            {{ $footer }}
        </div>
    @endif
</div>