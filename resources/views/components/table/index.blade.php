<div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm bg-white dark:bg-gray-800">
    <table {{ $attributes->merge(['class' => 'min-w-full divide-y w-full divide-gray-200 dark:divide-gray-700 text-sm text-left']) }}>
        {{ $slot }}
    </table>
</div>