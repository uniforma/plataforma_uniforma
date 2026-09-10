@extends('layouts.user-layout')

@section('title', 'UniForma — Vitrine de Submissões')

@section('content')
    <section class="overflow-hidden rounded-3xl bg-white shadow-sm">
        <div class="grid gap-8 p-6 sm:p-10 lg:grid-cols-[1.25fr_.75fr] lg:items-center">
            <div>
                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-blue-700">Vitrine colaborativa</span>
                <h1 class="mt-5 max-w-2xl text-3xl font-bold leading-tight text-slate-950 sm:text-4xl">Transforme necessidades em oportunidades de formação</h1>
                <p class="mt-4 max-w-2xl leading-7 text-slate-600">Colabore com a governança institucional propondo e apoiando demandas essenciais para a comunidade acadêmica.</p>
                @if (auth('admin')->check())
                    <span class="mt-7 inline-flex cursor-not-allowed rounded-xl bg-slate-200 px-5 py-3 text-sm font-semibold text-slate-500" title="Disponível para usuários comuns">+ Nova Demanda</span>
                @else
                    <a href="{{ route('user.submissions.create') }}" class="mt-7 inline-flex rounded-xl bg-[#0040A1] px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-900">+ Nova Demanda</a>
                @endif
            </div>

            <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                <div class="flex items-center gap-4 rounded-2xl border border-slate-200 p-4">
                    <span class="grid h-12 w-12 place-items-center rounded-full bg-blue-100 text-xl text-blue-700"><i class="ph ph-files"></i></span>
                    <div><p class="text-xs font-bold uppercase tracking-wider text-slate-500">Demandas ativas</p><p class="text-2xl font-bold text-slate-950">{{ number_format($metrics['active'], 0, ',', '.') }}</p></div>
                </div>
                <div class="flex items-center gap-4 rounded-2xl border border-slate-200 p-4">
                    <span class="grid h-12 w-12 place-items-center rounded-full bg-purple-100 text-xl text-purple-700"><i class="ph ph-thumbs-up"></i></span>
                    <div><p class="text-xs font-bold uppercase tracking-wider text-slate-500">Votos realizados</p><p class="text-2xl font-bold text-slate-950">{{ number_format($metrics['votes'], 0, ',', '.') }}</p></div>
                </div>
                <div class="flex items-center gap-4 rounded-2xl border border-slate-200 p-4">
                    <span class="grid h-12 w-12 place-items-center rounded-full bg-emerald-100 text-xl text-emerald-700"><i class="ph ph-seal-check"></i></span>
                    <div><p class="text-xs font-bold uppercase tracking-wider text-slate-500">Oficializadas</p><p class="text-2xl font-bold text-slate-950">{{ number_format($metrics['official'], 0, ',', '.') }}</p></div>
                </div>
            </div>
        </div>
    </section>

    <section id="submissoes" x-data="{ tab: 'voted' }" class="scroll-mt-28 py-10">
        <div class="flex flex-col gap-4 border-b border-slate-200 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-blue-700">Demandas da comunidade</p>
                <h2 class="mt-1 text-2xl font-bold text-slate-950">Encontre uma iniciativa para apoiar</h2>
            </div>
            <div class="flex gap-5">
                <button @click="tab = 'voted'" :class="tab === 'voted' ? 'border-blue-700 text-blue-700' : 'border-transparent text-slate-500'" class="border-b-2 pb-3 text-sm font-semibold">Mais votadas</button>
                <button @click="tab = 'recent'" :class="tab === 'recent' ? 'border-blue-700 text-blue-700' : 'border-transparent text-slate-500'" class="border-b-2 pb-3 text-sm font-semibold">Mais recentes</button>
            </div>
        </div>

        <div x-show="tab === 'voted'" class="mt-6 grid gap-5">
            @forelse ($voteDemands as $demand)
                @include('users.partials.demand-card', ['demand' => $demand])
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500">Ainda não há demandas disponíveis.</div>
            @endforelse
        </div>

        <div x-show="tab === 'recent'" x-cloak class="mt-6 grid gap-5">
            @forelse ($recentDemands as $demand)
                @include('users.partials.demand-card', ['demand' => $demand])
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500">Ainda não há demandas recentes.</div>
            @endforelse
        </div>
    </section>
@endsection
