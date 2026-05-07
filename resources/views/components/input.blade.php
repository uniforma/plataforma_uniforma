@props([
    'disabled' => false,
    'name',
    'label' => false,
    'type' => 'text',
    'messages' => [],
    'value' => null
])

<div class="flex w-full flex-col gap-1">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-600 transition-colors duration-200 dark:text-gray-200">
            {{ $label }}
        </label>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $value ?? old($name) }}"
        @disabled($disabled)
        {{ $attributes->merge([
            'class' => 'w-full rounded-md border border-gray-200 bg-[#EEEEEE] px-3 py-2 text-sm text-gray-900 outline-none transition-all duration-300 ease-in-out placeholder:text-gray-400 focus:border-primary-500 dark:border-white/10 dark:bg-surface-800 dark:text-gray-100 ' .
                       ($messages
                            ? 'border-red-500 focus:border-red-500 text-red-900 placeholder-red-300'
                            : 'hover:border-gray-300 dark:hover:border-white/20 dark:focus:border-primary-400')
        ]) }}
    >

    @if ($messages)
        <ul class="mt-1 space-y-1 text-sm text-red-600 transition-all duration-300 ease-in-out opacity-100 transform translate-y-0 dark:text-red-400">
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif
</div>
