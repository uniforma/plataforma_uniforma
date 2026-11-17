<div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm  ">
    <table {{ $attributes->merge(['class' => 'min-w-full w-full divide-y divide-gray-200 text-left text-sm ']) }}>
        {{ $slot }}
    </table>
</div>
