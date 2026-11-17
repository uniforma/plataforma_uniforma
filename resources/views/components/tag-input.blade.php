@props(['name', 'label', 'values' => [], 'kind'])
@php
    $selected = old($name, $values);
    $options = \App\Models\KnowledgeTerm::options($kind)->all();
@endphp
<div x-data="tagInput(@js(is_array($selected) ? array_values($selected) : []), @js($options))" class="min-w-0 space-y-2">
    <label for="{{ $name }}-entry" class="block text-sm font-semibold text-slate-700">{{ $label }} <span class="text-red-600">*</span></label>
    <div class="relative" @click.outside="open = false">
        <div class="flex min-h-12 flex-wrap gap-2 rounded-xl border border-slate-300 bg-white p-2 focus-within:border-primary-500 focus-within:ring-2 focus-within:ring-primary-500/20">
            <template x-for="tag in tags" :key="tag">
                <span class="inline-flex max-w-full items-center gap-1 rounded-lg bg-primary-50 px-2.5 py-1 text-xs font-semibold text-primary-600">
                    <span class="truncate" x-text="tag"></span>
                    <button type="button" @click="remove(tag)" class="rounded p-0.5 hover:bg-primary-100" :aria-label="'Remover ' + tag">×</button>
                    <input type="hidden" name="{{ $name }}[]" :value="tag">
                </span>
            </template>
            <input id="{{ $name }}-entry" x-model="entry" @input="entry = normalize(entry); open = true" @focus="open = true" @keydown.enter.prevent="add()" @keydown.tab="add()" type="text" maxlength="80" autocomplete="off" placeholder="Pesquise ou crie uma opção" class="min-w-36 flex-1 border-0 bg-transparent px-2 py-1 text-sm uppercase outline-none placeholder:normal-case focus:ring-0" role="combobox" aria-autocomplete="list" :aria-expanded="open.toString()">
            <button type="button" @click="add()" class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-200">Adicionar</button>
        </div>
        <div x-show="open && available.length" x-cloak class="absolute z-30 mt-1 max-h-52 w-full overflow-y-auto rounded-xl border border-slate-200 bg-white p-1 shadow-lg">
            <template x-for="option in available" :key="option"><button type="button" @click="select(option)" class="block w-full rounded-lg px-3 py-2 text-left text-sm hover:bg-primary-50" x-text="option"></button></template>
        </div>
    </div>
    <p class="text-xs text-slate-500">Selecione opções existentes ou digite uma nova e pressione Enter. Até 20 opções.</p>
    @error($name)<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    @error($name.'.*')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
</div>
