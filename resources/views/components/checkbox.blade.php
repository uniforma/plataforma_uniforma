@props([
    'disabled' => false,
    'name',
    'label' => null,
    'description' => null,
    'value' => 1,
    'checked' => false,
    'messages' => [],
])

@php
    $inputId = $attributes->get('id', $name);
    $hasMessages = ! empty($messages);
@endphp

<label {{ $attributes->except('id')->class([
    'group block',
    $disabled ? 'cursor-not-allowed opacity-60' : 'cursor-pointer',
]) }}>
    <input
        id="{{ $inputId }}"
        name="{{ $name }}"
        type="checkbox"
        value="{{ $value }}"
        @checked($checked)
        @disabled($disabled)
        class="peer sr-only"
    >

    <span class="flex h-full items-start gap-3 rounded-xl border border-gray-200 bg-white p-4 transition duration-200 ease-in-out group-hover:border-gray-300 group-hover:shadow-sm peer-checked:border-primary-500 peer-checked:bg-primary-400/20 dark:border-gray-700 dark:bg-gray-900/60 dark:group-hover:border-gray-600 dark:peer-checked:border-primary-500 dark:peer-checked:bg-gray-900">
        {{-- <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-white text-white transition peer-checked:border-blue-600 peer-checked:bg-blue-600 dark:border-gray-600 dark:bg-gray-950">
            <svg viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5 opacity-0 transition peer-checked:opacity-100">
                <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 0 1.414l-7.071 7.071a1 1 0 0 1-1.414 0L3.296 9.856A1 1 0 1 1 4.71 8.44l3.216 3.217 6.364-6.364a1 1 0 0 1 1.414 0Z" clip-rule="evenodd" />
            </svg>
        </span> --}}

        <span class="min-w-0 flex-1">
            <span class="block text-sm font-semibold text-gray-900 dark:text-gray-100">
                {{ $label ?? $slot }}
            </span>

            @if($description)
                <span class="mt-1 block text-xs leading-5 text-gray-500 dark:text-gray-400">
                    {{ $description }}
                </span>
            @endif

            @if($hasMessages)
                <ul class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-400">
                    @foreach((array) $messages as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </span>
    </span>
</label>