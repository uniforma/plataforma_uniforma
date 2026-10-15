@extends('layouts.user-layout')

{{-- 1. Título dinâmico --}}
@section('title', (isset($demand) ? 'Editar Demanda' : 'Nova Demanda') . ' — UniForma')

@section('content')

<div class="mx-auto max-w-4xl">


    <a href="{{ route('user.submissions.index') }}"
       class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-slate-500
              transition hover:text-[#0040A1]">
        <i class="ph ph-arrow-left text-lg"></i>
        Voltar para minhas demandas
    </a>


    <div class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
            {{ isset($demand) ? 'Editar Demanda' : 'Nova Demanda' }}
        </h1>
        <p class="mt-3 max-w-1xl leading-7 text-slate-600">
            {{ isset($demand) ? 'Atualize as informações da sua demanda conforme necessário.' : 'Descreva sua proposta com clareza para facilitar a compreensão e o apoio dos demais usuários.' }}
        </p>
    </div>


    <form method="POST"
          action="{{ isset($demand) ? route('user.submissions.update', $demand->id) : route('user.submissions.store') }}"
          class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        @csrf
        
      
        @if(isset($demand))
            @method('PUT')
        @endif

        <div class="border-b border-slate-100 p-6 sm:p-8">
            <div class="mb-7 flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#0040A1] text-sm font-bold text-white">1</div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Informações da demanda</h2>
                    <p class="mt-1 text-sm text-slate-500">Informe o título e explique a necessidade identificada.</p>
                </div>
            </div>

            <div class="space-y-6">
            
                <div>
                    <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Título da demanda <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title"
                           value="{{ old('title', $demand->title ?? '') }}"
                           required autofocus placeholder="Ex.: Capacitação em Inteligência Artificial para docentes"
                           class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#0040A1] focus:ring-4 focus:ring-blue-100">
                    <p class="mt-2 text-xs text-slate-500">Escolha um título curto e objetivo.</p>
                    @error('title')
                        <p class="mt-2 flex items-center gap-1 text-sm font-medium text-red-600"><i class="ph ph-warning-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="background" class="mb-2 block text-sm font-semibold text-slate-700">Contexto e justificativa <span class="text-red-500">*</span></label>
                    <textarea id="background" name="background" rows="7" required placeholder="Descreva o problema identificado..."
                              class="block w-full resize-none rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#0040A1] focus:ring-4 focus:ring-blue-100"
                    >{{ old('background', $demand->background ?? '') }}</textarea>
                    <div class="mt-2 flex items-center gap-2 text-xs text-slate-500"><i class="ph ph-info"></i> Quanto mais claro o contexto, mais fácil será compreender a proposta.</div>
                    @error('background')
                        <p class="mt-2 flex items-center gap-1 text-sm font-medium text-red-600"><i class="ph ph-warning-circle"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8">
            <div class="mb-7 flex items-start gap-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#0040A1] text-sm font-bold text-white">2</div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Público e área</h2>
                    <p class="mt-1 text-sm text-slate-500">Identifique quem será beneficiado e a área relacionada à demanda.</p>
                </div>
            </div>

            <div class="grid gap-6 space-y-1">
                <div>
                    <label for="target_audience" class="mb-2 block text-sm font-semibold text-slate-700">Público-alvo <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="ph ph-users absolute left-4 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>
                        <input type="text" id="target_audience" name="target_audience"
                               value="{{ old('target_audience', $demand->target_audience ?? '') }}"
                               required placeholder="Ex.: Professores e acadêmicos"
                               class="block w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-[#0040A1] focus:ring-4 focus:ring-blue-100">
                    </div>
                    @error('target_audience')
                        <p class="mt-2 flex items-center gap-1 text-sm font-medium text-red-600"><i class="ph ph-warning-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="knowledge_field" class="mb-2 block text-sm font-semibold text-slate-700">Área do conhecimento <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <i class="ph ph-books absolute left-4 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>
                        
                       
                        @php $selectedArea = old('knowledge_field', $demand->knowledge_field ?? ''); @endphp
                        
                        <select id="knowledge_field" name="knowledge_field" required
                                class="block w-full appearance-none rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-10 text-sm text-slate-900 outline-none transition focus:border-[#0040A1] focus:ring-4 focus:ring-blue-100">
                            <option value="">Selecione uma área</option>
                            <option value="Tecnologia" {{ $selectedArea === 'Tecnologia' ? 'selected' : '' }}>Tecnologia</option>
                            <option value="Educação" {{ $selectedArea === 'Educação' ? 'selected' : '' }}>Educação</option>
                            <option value="Saúde" {{ $selectedArea === 'Saúde' ? 'selected' : '' }}>Saúde</option>
                            <option value="Gestão" {{ $selectedArea === 'Gestão' ? 'selected' : '' }}>Gestão</option>
                            <option value="Outros" {{ $selectedArea === 'Outros' ? 'selected' : '' }}>Outros</option>
                        </select>
                        <i class="ph ph-caret-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    </div>
                    @error('knowledge_field')
                        <p class="mt-2 flex items-center gap-1 text-sm font-medium text-red-600"><i class="ph ph-warning-circle"></i> {{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <p class="flex items-center gap-2 text-xs text-slate-500"><i class="ph ph-info text-base"></i> Os campos marcados com * são obrigatórios.</p>
            <div class="flex flex-col-reverse gap-3 sm:flex-row">
                <a href="{{ route('user.submissions.index') }}"
                   class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-6 text-sm font-semibold text-slate-600 transition hover:border-slate-400 hover:bg-slate-100">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-[#0040A1] px-7 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-900 active:scale-[0.98]">
                    <i class="ph ph-paper-plane-tilt text-lg"></i>
                    {{ isset($demand) ? 'Salvar alterações' : 'Publicar demanda' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection