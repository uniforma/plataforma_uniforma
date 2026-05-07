<div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm dark:border-white/5 dark:bg-[#333931]">
    <table {{ $attributes->merge(['class' => 'min-w-full w-full divide-y divide-gray-200 text-left text-sm dark:divide-white/5']) }}>
        {{ $slot }}
    </table>
</div>