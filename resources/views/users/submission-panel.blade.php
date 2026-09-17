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

        <div class="grid gap-4 md:grid-cols-3">

            {{-- Busca --}}
            <div class="md:col-span-2">

                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Buscar submissão
                </label>

                <div class="relative">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
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
                        placeholder="Pesquise pelo título da demanda..."
                        class="w-full rounded-xl border border-slate-300
                               py-3 pl-12 pr-4 text-sm
                               outline-none transition
                               focus:border-[#0040A1]
                               focus:ring-2 focus:ring-blue-100"
                    >

                </div>

            </div>


            {{-- Filtro status --}}
            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Status
                </label>

                <select
                    class="w-full rounded-xl border border-slate-300
                           bg-white px-4 py-3 text-sm
                           outline-none transition
                           focus:border-[#0040A1]
                           focus:ring-2 focus:ring-blue-100"
                >
                    <option>Todos os status</option>
                    <option>Em votação</option>
                    <option>Alta relevância</option>
                    <option>Em curadoria</option>
                    <option>Oficializado</option>
                    <option>Arquivado</option>
                </select>

            </div>

        </div>

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

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"
                            />

                            <circle
                                cx="12"
                                cy="7"
                                r="4"
                            />
                        </svg>

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
            <div
                class="mt-6 flex flex-col gap-4 border-t
                       border-slate-100 pt-5 sm:flex-row
                       sm:items-center sm:justify-between"
            >

                <div class="text-sm text-slate-500">
                    Público-alvo:

                    <span class="font-semibold text-slate-700">
                        {{ $demand->target_audience }}
                    </span>
                </div>

                <a
                    href="##"
                    class="inline-flex items-center justify-center
                           rounded-xl border border-slate-300
                           px-5 py-2.5 text-sm font-semibold
                           text-slate-600 transition
                           hover:border-[#0040A1]
                           hover:text-[#0040A1]"
                >
                    Ver detalhes
                </a>

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