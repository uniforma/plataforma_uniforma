<x-admin-layout>
<div class="w-full space-y-4 px-3 py-4 sm:px-4 lg:px-5">
    <header class="flex flex-wrap items-center justify-between gap-3 rounded-2xl bg-[#142c59] px-5 py-4 text-white">
        <div><p class="text-xs font-bold uppercase tracking-widest text-[#4be0bc]">Painel administrativo</p><h1 class="mt-1 text-xl font-bold sm:text-2xl">Visão geral da UniForma</h1><p class="mt-1 text-xs text-blue-100">Olá, {{ auth('admin')->user()->name }} · {{ now()->translatedFormat('d \d\e F \d\e Y') }}</p></div>
        <div class="flex flex-wrap items-center gap-2 text-sm">
            <a href="#notificacoes" class="inline-flex items-center gap-2 rounded-xl border border-white/25 px-3 py-2 font-semibold hover:bg-white/10"><i class="ph ph-bell text-lg"></i>Notificações @if ($pendingProposalsCount)<span class="rounded-full bg-[#3bd5aa] px-2 text-xs font-bold text-[#142c59]">{{ $pendingProposalsCount }}</span>@endif</a>
            @can('review_teaching_proposals')<a href="{{ route('admin.proposals.index') }}" class="rounded-xl bg-[#3bd5aa] px-3 py-2 font-bold text-[#142c59]">Analisar propostas</a>@endcan
        </div>
    </header>

    <section aria-label="Indicadores principais" class="grid grid-cols-2 gap-3 md:grid-cols-3 2xl:grid-cols-6">
        @foreach ([
            ['Submissões', $submissionsCount, 'ph-files', 'blue'],
            ['Votos', $votesCount, 'ph-thumbs-up', 'violet'],
            ['Interesses', $interestsCount, 'ph-chalkboard-teacher', 'emerald'],
            ['Propostas pendentes', $pendingProposalsCount, 'ph-clipboard-text', 'amber'],
            ['Formações aprovadas', $approvedProposalsCount, 'ph-seal-check', 'blue'],
            ['Inscrições', $registrationsCount, 'ph-ticket', 'violet'],
        ] as [$label, $value, $icon, $color])
            <article class="min-w-0 rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-sm"><div class="flex items-start justify-between gap-2"><p class="text-xs font-medium text-slate-500">{{ $label }}</p><i class="ph {{ $icon }} text-lg text-blue-700"></i></div><p class="mt-2 text-2xl font-bold text-[#142c59]">{{ number_format($value, 0, ',', '.') }}</p></article>
        @endforeach
    </section>

    <section aria-label="Indicadores de fluxo" class="grid gap-3 sm:grid-cols-3">
        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white px-4 py-3"><span class="text-sm text-slate-600">Usuários cadastrados</span><strong class="text-lg text-[#142c59]">{{ $usersCount }}</strong></div>
        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white px-4 py-3"><span class="text-sm text-slate-600">Aguardando ministrantes</span><strong class="text-lg text-[#142c59]">{{ $readySubmissionsCount }}</strong></div>
        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white px-4 py-3"><span class="text-sm text-slate-600">Demandas oficializadas</span><strong class="text-lg text-[#142c59]">{{ $conversionRate }}% <small class="font-normal text-slate-500">do total</small></strong></div>
    </section>

    <section class="grid gap-3 xl:grid-cols-3" aria-label="Evolução nos últimos seis meses">
        @foreach ([['Novas submissões', 'submissions', 'bg-blue-600', 'text-blue-700'], ['Votos registrados', 'votes', 'bg-violet-600', 'text-violet-700'], ['Novas inscrições', 'registrations', 'bg-emerald-600', 'text-emerald-700']] as [$title, $key, $bar, $text])
            @php($peak = max(1, $months->max($key)))
            <article class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-center justify-between gap-2"><h2 class="font-bold text-[#142c59]">{{ $title }}</h2><strong class="{{ $text }}">{{ $months->sum($key) }}</strong></div>
                <p class="text-xs text-slate-500">Últimos 6 meses</p>
                <div class="mt-4 grid h-36 grid-cols-6 items-end gap-2" role="img" aria-label="{{ $title }}: @foreach ($months as $month) {{ $month['label'] }} {{ $month[$key] }}; @endforeach">
                    @foreach ($months as $month)<div class="flex h-full min-w-0 flex-col items-center justify-end gap-1"><span class="text-xs font-semibold text-slate-600">{{ $month[$key] }}</span><div class="w-full max-w-12 rounded-t-md {{ $bar }}" style="height: {{ $month[$key] ? max(8, round($month[$key] / $peak * 100)) : 3 }}%"></div><span class="w-full truncate text-center text-[10px] font-medium uppercase text-slate-500">{{ $month['label'] }}</span></div>@endforeach
                </div>
            </article>
        @endforeach
    </section>

    <section class="grid gap-3 lg:grid-cols-2 2xl:grid-cols-3" aria-label="Distribuições">
        @foreach ([['Etapas das submissões', $statusCounts, $submissionsCount, 'bg-blue-600'], ['Situação das propostas', $proposalCounts, $proposalCounts->sum('count'), 'bg-violet-600']] as [$title, $items, $total, $bar])
            <article class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm"><h2 class="font-bold text-[#142c59]">{{ $title }}</h2><div class="mt-4 space-y-3">@foreach ($items as $item)<div><div class="mb-1 flex justify-between gap-2 text-xs"><span class="truncate text-slate-600">{{ $item['label'] }}</span><strong>{{ $item['count'] }}</strong></div><div class="h-2 rounded-full bg-slate-100"><div class="h-2 rounded-full {{ $bar }}" style="width: {{ $total ? round($item['count'] / $total * 100) : 0 }}%"></div></div></div>@endforeach</div></article>
        @endforeach
        <article class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm lg:col-span-2 2xl:col-span-1"><h2 class="font-bold text-[#142c59]">Áreas mais solicitadas</h2><div class="mt-4 space-y-3">@forelse ($topFields as $field)<div><div class="mb-1 flex justify-between gap-2 text-xs"><span class="truncate text-slate-600">{{ $field->knowledge_field }}</span><strong>{{ $field->total }}</strong></div><div class="h-2 rounded-full bg-slate-100"><div class="h-2 rounded-full bg-emerald-500" style="width: {{ $submissionsCount ? round($field->total / $submissionsCount * 100) : 0 }}%"></div></div></div>@empty<p class="text-sm text-slate-500">Sem dados ainda.</p>@endforelse</div></article>
    </section>

    <section class="grid gap-3 xl:grid-cols-[minmax(0,1fr)_minmax(0,1fr)]">
        <article id="notificacoes" class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm"><div class="flex items-center justify-between gap-2"><h2 class="font-bold text-[#142c59]"><i class="ph ph-bell mr-2 text-blue-700"></i>Notificações</h2>@can('review_teaching_proposals')<a href="{{ route('admin.proposals.index') }}" class="text-xs font-semibold text-blue-700">Ver propostas →</a>@endcan</div><p class="mt-1 text-xs text-slate-500">Itens que precisam de atenção</p><div class="mt-3 divide-y divide-slate-100">@forelse ($pendingProposals as $proposal)<div class="flex items-start gap-3 py-2"><span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-amber-500"></span><div class="min-w-0"><p class="truncate text-sm font-semibold text-slate-800">Proposta aguardando análise: {{ $proposal->submissao?->title }}</p><p class="text-xs text-slate-500">{{ $proposal->user?->name }} · {{ $proposal->created_at?->diffForHumans() }}</p></div></div>@empty<p class="py-3 text-sm text-slate-500">Nenhuma proposta pendente no momento.</p>@endforelse</div></article>
        <article class="min-w-0 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm"><div class="flex items-center justify-between gap-2"><h2 class="font-bold text-[#142c59]">Submissões recentes</h2>@can('view_submissoes')<a href="{{ route('submissions.index') }}" class="text-xs font-semibold text-blue-700">Ver todas →</a>@endcan</div><div class="mt-3 divide-y divide-slate-100">@forelse ($recentSubmissions as $submission)<div class="flex min-w-0 items-center justify-between gap-3 py-2"><div class="min-w-0"><p class="truncate text-sm font-semibold text-slate-800">{{ $submission->title }}</p><p class="text-xs text-slate-500">{{ $submission->created_at?->format('d/m/Y') }} · {{ $submission->status->label() }}</p></div><span class="shrink-0 text-xs font-semibold text-blue-700">{{ $submission->votes_count }} votos</span></div>@empty<p class="py-3 text-sm text-slate-500">Nenhuma submissão cadastrada.</p>@endforelse</div></article>
    </section>

    <nav aria-label="Acesso rápido" class="flex flex-wrap items-center gap-2 rounded-xl border border-slate-200 bg-white p-3 text-xs font-semibold"><span class="mr-1 text-slate-500">Acesso rápido</span>@can('review_teaching_proposals')<a href="{{ route('admin.proposals.index') }}" class="rounded-lg bg-blue-50 px-3 py-2 text-blue-700">Propostas</a>@endcan @can('view_submissoes')<a href="{{ route('submissions.index') }}" class="rounded-lg bg-blue-50 px-3 py-2 text-blue-700">Submissões</a>@endcan @can('view_users')<a href="{{ route('users.index') }}" class="rounded-lg bg-blue-50 px-3 py-2 text-blue-700">Usuários</a>@endcan @can('view_logs')<a href="{{ route('logs.index') }}" class="rounded-lg bg-blue-50 px-3 py-2 text-blue-700">Logs</a>@endcan</nav>
</div>
</x-admin-layout>
