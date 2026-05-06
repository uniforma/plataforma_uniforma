@props([
    'disabled' => false,
    'name',
    'label' => false,
    'type' => 'text',
    'messages' => [],
    'value' => null
])

<div class="flex flex-col gap-1 w-full">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-600 dark:text-white transition-colors duration-200">
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
            'class' => 'w-full px-3 py-2 border border-[#CCCCCC] rounded-md bg-[#EEEEEE] dark:bg-[#333931] dark:border-[#CCCCCC] text-gray-900 dark:text-gray-100 outline-none transition-all duration-300 ease-in-out text-sm ' .
                       ($messages 
                            ? 'border-red-500 focus:border-red-500 text-red-900 placeholder-red-300' 
                            : 'border-gray-200 hover:border-gray-300 focus:border-primary-500 dark:border-surface-800 dark:hover:border-surface-800 dark:focus:border-primary-400')
        ]) }}
    >

    @if ($messages)
        <ul class="text-sm text-red-600 dark:text-red-400 space-y-1 mt-1 transition-all duration-300 ease-in-out opacity-100 transform translate-y-0">
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif
</div>
