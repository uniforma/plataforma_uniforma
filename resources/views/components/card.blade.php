<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm']) }}>
    @if(isset($header))
        <div class="border-b border-gray-200 px-4 py-4 sm:px-6 ">
            {{ $header }}
        </div>
    @endif

    <div class="px-4 py-5 sm:p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="border-t border-gray-200 bg-gray-50 px-4 py-4 sm:px-6  ">
            {{ $footer }}
        </div>
    @endif
</div>
