@props(['value' => ''])
@php($options = \App\Models\KnowledgeTerm::options(\App\Models\KnowledgeTerm::AREA))
<div>
    <label for="knowledge_field" class="mb-2 block text-sm font-semibold text-slate-700">Área do conhecimento <span class="text-red-600">*</span></label>
    <input id="knowledge_field" name="knowledge_field" list="knowledge-area-options" value="{{ old('knowledge_field', $value) }}" required maxlength="100" autocomplete="off" oninput="normalizeCatalogInput(this)" placeholder="Selecione ou digite uma nova área" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm uppercase text-slate-900 outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20">
    <datalist id="knowledge-area-options">@foreach ($options as $option)<option value="{{ $option }}">{{ $option }}</option>@endforeach</datalist>
    <p class="mt-2 text-xs text-slate-500">Escolha uma área cadastrada ou crie uma nova digitando seu nome.</p>
    @error('knowledge_field')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>
