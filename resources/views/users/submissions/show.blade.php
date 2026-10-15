@extends('layouts.user-layout')

@section('title', $demand->title . ' — UniForma')

@section('content')
    <div class="mb-6">
        <a href="{{ route('home') }}#submissoes" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-900"><i class="ph ph-arrow-left"></i> Voltar para a vitrine</a>
    </div>

    @include('users.partials.demand-card', ['demand' => $demand])

    <section class="mt-6 grid gap-6 lg:grid-cols-[1fr_320px]">
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h2 class="text-lg font-bold text-slate-950">Contexto da demanda</h2>
            <p class="mt-4 whitespace-pre-line leading-7 text-slate-600">{{ $demand->background }}</p>

            <div class="mt-8 grid gap-5 border-t border-slate-200 pt-6 sm:grid-cols-2">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Público-alvo</p>
                    <p class="mt-2 text-slate-800">{{ $demand->target_audience }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Área do conhecimento</p>
                    <p class="mt-2 text-slate-800">{{ $demand->knowledge_field }}</p>
                </div>
            </div>
        </article>

        <aside class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="font-bold text-slate-950">Acompanhamento</h2>
            <dl class="mt-5 space-y-5">
                <div><dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Status</dt><dd class="mt-1 font-semibold">{{ $demand->status->label() }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Curador</dt><dd class="mt-1">{{ $demand->curador?->name ?? 'Ainda não atribuído' }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Criada em</dt><dd class="mt-1">{{ $demand->created_at?->format('d/m/Y \à\s H:i') }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Atualizada em</dt><dd class="mt-1">{{ $demand->updated_at?->format('d/m/Y \à\s H:i') }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Apoios</dt><dd class="mt-1 text-2xl font-bold">{{ $demand->votes_count }}</dd></div>
                <div><dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Interessados em ministrar</dt><dd class="mt-1 text-2xl font-bold">{{ $demand->teaching_interests_count }}</dd></div>
            </dl>
        </aside>
    </section>
@endsection
