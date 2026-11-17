@props(['label' => null, 'messages' => []])

@php
    $id = $attributes->get('id', $attributes->get('name'));
@endphp

<span class="block min-w-0 w-full">
    @if ($label)
        <label for="{{ $id }}" class="mb-1 block text-sm font-medium text-slate-700">{{ $label }}</label>
    @endif
    <select {{ $attributes->except('class')->class([
        'w-full min-w-0 rounded-xl border bg-white px-4 py-3 pe-10 text-sm text-slate-900 shadow-sm outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20',
        'border-red-500' => count((array) $messages) > 0,
        'border-slate-300 hover:border-slate-400' => count((array) $messages) === 0,
    ]) }}>
        {{ $slot }}
    </select>
    @foreach ((array) $messages as $message)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @endforeach
</span>
