
@extends('layouts.user-layout')

@section('title', 'Submissões Enviadas')

@section('content')


<div class="space-y-8">

    {{-- Cabeçalho --}}
    <section class="rounded-3xl bg-white p-8 shadow-sm">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <span class="text-sm font-semibold text-[#0040A1]">
                    Comunidade UniForma
                </span>

                <h1 class="mt-2 text-3xl font-bold text-slate-950">
                    Submissões enviadas
                </h1>

                <p class="mt-3 max-w-2xl text-slate-500">
                    Explore as demandas enviadas pela comunidade acadêmica,
                    acompanhe seus status e conheça as propostas de formação.
                </p>
            </div>

            <a href=" {{ route('user.submissions.create') }} "
               class="inline-flex items-center justify-center rounded-xl
                      bg-[#0040A1] px-6 py-3 text-sm font-semibold
                      text-white transition hover:bg-blue-900">

                + Nova Demanda
            </a>

        </div>

    </section>


{{-- Busca e filtros --}}
<section class="rounded-2xl bg-white p-6 shadow-sm">

    <form method="GET" action="{{ route('user.submissions.showSub') }}">

        <div class="grid gap-4 md:grid-cols-12 md:items-end">

            {{-- Busca --}}
            <div class="md:col-span-7">

                <label
                    for="search"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Buscar submissões
                </label>

                <div class="relative">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m21 21-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"
                        />
                    </svg>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Pesquise pelo título da demanda..."
                        class="w-full rounded-xl border border-slate-300
                               py-3 pl-12 pr-4 text-sm
                               outline-none transition
                               focus:border-[#0040A1]
                               focus:ring-2 focus:ring-blue-100"
                    >

                </div>

            </div>


            {{-- Filtro por status --}}
            <div class="md:col-span-3">

                <label
                    for="status"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="w-full rounded-xl border border-slate-300
                           bg-white px-4 py-3 text-sm
                           outline-none transition
                           focus:border-[#0040A1]
                           focus:ring-2 focus:ring-blue-100"
                >

                    <option value="">
                        Todos os status
                    </option>

                    <option
                        value="Em votação"
                        @selected(request('status') === 'Em votação')
                    >
                        Em votação
                    </option>

                    <option
                        value="Alta Relevância"
                        @selected(request('status') === 'Alta Relevância')
                    >
                        Alta relevância
                    </option>

                    <option
                        value="Em Curadoria"
                        @selected(request('status') === 'Em Curadoria')
                    >
                        Em curadoria
                    </option>

                    <option
                        value="Oficializado"
                        @selected(request('status') === 'Oficializado')
                    >
                        Oficializado
                    </option>

                    <option
                        value="Arquivado"
                        @selected(request('status') === 'Arquivado')
                    >
                        Arquivado
                    </option>

                </select>

            </div>


            {{-- Botão Buscar --}}
            <div class="md:col-span-2">

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center gap-2
                           rounded-xl bg-[#0040A1] px-5 py-3
                           text-sm font-semibold text-white
                           transition
                           hover:bg-blue-900
                           focus:outline-none
                           focus:ring-2
                           focus:ring-blue-200
                           focus:ring-offset-2
                           active:scale-[0.98]"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m21 21-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"
                        />
                    </svg>

                    Buscar

                </button>

            </div>

        </div>


        {{-- Filtros ativos --}}
        @if(request('search') || request('status'))

            <div
                class="mt-5 flex flex-col gap-3 border-t border-slate-100 pt-4
                       sm:flex-row sm:items-center sm:justify-between"
            >

                <div class="flex flex-wrap items-center gap-2">

                    <span class="text-sm font-medium text-slate-500">
                        Filtros aplicados:
                    </span>


                    {{-- Pesquisa aplicada --}}
                    @if(request('search'))

                        <a
                            href="{{ route(
                                'user.submissions.index',
                                request()->except(['search', 'page'])
                            ) }}"
                            class="inline-flex items-center gap-2
                                   rounded-full bg-blue-50 px-3 py-1.5
                                   text-xs font-semibold text-[#0040A1]
                                   transition hover:bg-blue-100"
                            title="Remover filtro de pesquisa"
                        >
                            Busca: "{{ request('search') }}"

                            <span
                                aria-hidden="true"
                                class="text-base leading-none"
                            >
                                ×
                            </span>

                        </a>

                    @endif


                    {{-- Status aplicado --}}
                    @if(request('status'))

                        <a
                            href="{{ route(
                                'user.submissions.index',
                                request()->except(['status', 'page'])
                            ) }}"
                            class="inline-flex items-center gap-2
                                   rounded-full bg-blue-50 px-3 py-1.5
                                   text-xs font-semibold text-[#0040A1]
                                   transition hover:bg-blue-100"
                            title="Remover filtro de status"
                        >
                            {{ request('status') }}

                            <span
                                aria-hidden="true"
                                class="text-base leading-none"
                            >
                                ×
                            </span>

                        </a>

                    @endif

                </div>


                {{-- Limpar todos --}}
                <a
                    href="{{ route('user.submissions.showSub') }}"
                    class="shrink-0 text-sm font-semibold text-slate-500
                           transition hover:text-[#0040A1]"
                >
                    Limpar filtros
                </a>

            </div>

        @endif

    </form>

</section>


    {{-- Quantidade --}}
<div class="flex items-center justify-between">

    <div>
        <h2 class="text-xl font-bold text-slate-950">
            Demandas da comunidade
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ $allDemands->total() }}
            {{ $allDemands->total() === 1 ? 'submissão encontrada' : 'submissões encontradas' }}
        </p>
    </div>

</div>


{{-- LISTA DE SUBMISSÕES --}}
<div class="grid gap-5">



   @forelse ($allDemands as $demand)

        @php
            $viewer = auth('user')->user();
            $adminViewer = auth('admin')->user();
            $isOpen = $demand->status->allowsInteractions();
            $isAuthor = $viewer && $demand->autor_id === $viewer->id;
            
           
            $canTeach = $viewer?->roles->contains(fn ($role) => in_array($role->name, ['docente', 'tecnico'], true)) ?? false;
            
            $supported = (bool) ($demand->supported_by_current_user ?? false);
            $interested = (bool) ($demand->teaching_interest_by_current_user ?? false);
        @endphp

        @php
            $status = $demand->status instanceof \BackedEnum
                ? $demand->status->value
                : $demand->status;

            $statusClass = match ($status) {
                'Em votação' => 'bg-blue-100 text-blue-700',
                'Alta Relevância' => 'bg-purple-100 text-purple-700',
                'Em Curadoria' => 'bg-amber-100 text-amber-700',
                'Oficializado' => 'bg-emerald-100 text-emerald-700',
                'Arquivado' => 'bg-slate-200 text-slate-600',
                default => 'bg-slate-100 text-slate-600',
            };
        @endphp

        <article
            class="rounded-2xl border border-slate-200
                   bg-white p-6 shadow-sm transition
                   hover:-translate-y-0.5 hover:shadow-md"
        >

            <div class="flex flex-col gap-5 lg:flex-row lg:justify-between">

                <div class="flex-1">

                    {{-- Status + Área --}}
                    <div class="flex flex-wrap items-center gap-2">

                        <span
                            class="rounded-full px-3 py-1
                                   text-xs font-semibold {{ $statusClass }}"
                        >
                            {{ $status }}
                        </span>

                        <span
                            class="rounded-full bg-slate-100
                                   px-3 py-1 text-xs font-semibold
                                   text-slate-600"
                        >
                            {{ $demand->knowledge_field }}
                        </span>

                    </div>


                    {{-- Título --}}
                    <h3 class="mt-4 text-xl font-bold text-slate-950">
                        {{ $demand->title }}
                    </h3>


                    {{-- Autor + data --}}
                    <div class="mt-3 flex items-center gap-2 text-sm text-slate-500">

                        <i class="ph ph-user"></i>

                        <span>
                            Enviado por {{ $demand->autor?->name ?? 'Autor não informado' }}
                        </span>

                        <span>•</span>

                        <span>
                            {{ $demand->created_at?->format('d/m/Y') }}
                        </span>

                    </div>


                    {{-- Descrição --}}
                    <p class="mt-5 max-w-4xl leading-7 text-slate-600">
                        {{ $demand->background }}
                    </p>

                </div>


                {{-- Número de votos --}}
                <div
                    class="flex min-w-[120px] items-center
                           justify-center rounded-2xl bg-slate-50 p-5"
                >

                    <div class="text-center">

                       <p class="text-3xl font-bold text-[#0040A1]">
                            {{ $demand->votes_count }}
                        </p>

                        <p class="mt-1 text-xs font-semibold uppercase text-slate-500">
                            Apoios
                        </p>

                    </div>

                </div>

            </div>


            {{-- Rodapé do card --}}
           {{-- Rodapé do card --}}
<div
    class="mt-6 flex flex-col gap-4 border-t
           border-slate-100 pt-5
           lg:flex-row lg:items-center lg:justify-between"
>

    {{-- Público-alvo --}}



    {{-- Ações --}}
    {{-- Ações --}}
<div class="flex flex-wrap gap-3">

    @if (! $viewer && ! $adminViewer)
        {{-- VISITANTES NÃO LOGADOS: Redireciona para o login --}}
        @if ($isOpen)
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0040A1] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-900 active:scale-[0.98]">
                Apoiar Demanda
            </a>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 active:scale-[0.98]">
                Quero Ministrar
            </a>
        @else
            <span class="cursor-not-allowed inline-flex items-center justify-center gap-2 rounded-xl bg-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-500">Apoiar Demanda</span>
            <span class="cursor-not-allowed inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-400">Quero Ministrar</span>
        @endif

    @elseif ($viewer)
        {{-- USUÁRIOS COMUNS LOGADOS: Formulários POST/DELETE reais --}}
        
        {{-- 1. Botão de Apoiar --}}
        @if ($isOpen && ! $isAuthor)
            <form method="POST" action="{{ $supported ? route('user.submissions.support.destroy', ['submission' => $demand->id]) : route('user.submissions.support', ['submission' => $demand->id]) }}">
                @csrf
                @if ($supported) @method('DELETE') @endif
                
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0040A1] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-900 active:scale-[0.98]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2" />
                    </svg>
                    {{ $supported ? 'Retirar Apoio' : 'Apoiar Demanda' }}
                </button>
            </form>
        @else
            <span class="cursor-not-allowed inline-flex items-center justify-center gap-2 rounded-xl bg-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-500" title="{{ $isAuthor ? 'Você não pode apoiar a própria demanda' : 'Interações encerradas' }}">Apoiar Demanda</span>
        @endif

        {{-- 2. Botão de Ministrar --}}
        @if ($isOpen && ($canTeach || $interested))
            <form method="POST" action="{{ $interested ? route('user.submissions.teaching-interest.destroy', ['submission' => $demand->id]) : route('user.submissions.teaching-interest', ['submission' => $demand->id]) }}">
                @csrf
                @if ($interested) @method('DELETE') @endif
                
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 active:scale-[0.98]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7" />
                    </svg>
                    {{ $interested ? 'Retirar Interesse' : 'Quero Ministrar' }}
                </button>
            </form>
        @else
            <span class="cursor-not-allowed inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-400">Quero Ministrar</span>
        @endif

    @else
        {{-- ADMINISTRADORES: Botões bloqueados --}}
        <span class="cursor-not-allowed inline-flex items-center justify-center gap-2 rounded-xl bg-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-500" title="Disponível para usuários comuns">Apoiar Demanda</span>
        <span class="cursor-not-allowed inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-400" title="Disponível para usuários comuns">Quero Ministrar</span>
    @endif

    {{-- Botão de Detalhes (Link comum funciona perfeitamente aqui) --}}
    <a href="{{ route('demands.show', $demand->id) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-[#0040A1] hover:bg-slate-50 hover:text-[#0040A1]">
        Ver detalhes
    </a>

</div>

</div>
        </article>

    @empty

        <div
            class="rounded-2xl border border-dashed border-slate-300
                   bg-white p-10 text-center text-slate-500"
        >
            Nenhuma submissão encontrada.
        </div>

    @endforelse

</div>



@if ($allDemands->hasPages())

    <div class="mt-8">
        {{ $allDemands->links() }}
    </div>

@endif

@endsection