@php
    $viewer = auth('user')->user();
    $adminViewer = auth('admin')->user();
    $isOpen = $demand->status->allowsInteractions();
    $isAuthor = $viewer && $demand->autor_id === $viewer->id;
    $canTeach = $viewer?->roles->contains(fn ($role) => in_array($role->name, ['docente', 'tecnico'], true)) ?? false;
    $supported = (bool) ($demand->supported_by_current_user ?? false);
    $interested = (bool) ($demand->teaching_interest_by_current_user ?? false);
    $loginReturn = route('demands.show', $demand->id, absolute: false);
@endphp

<article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md sm:p-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div class="min-w-0">
            <div class="mb-3 flex flex-wrap items-center gap-2">
                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">{{ $demand->status->label() }}</span>
                <span class="text-xs text-slate-500">{{ $demand->created_at?->format('d/m/Y') }}</span>
            </div>
            <h2 class="text-xl font-bold text-slate-900">{{ $demand->title }}</h2>
            <p class="mt-2 flex items-center gap-2 text-sm text-slate-500">
                <i class="ph ph-user"></i>{{ $demand->autor?->name ?? 'Autor removido' }}
            </p>
        </div>
        <div class="flex shrink-0 gap-3 text-sm text-slate-600">
            <span class="flex items-center gap-1 rounded-lg bg-slate-100 px-3 py-2" title="Apoios"><i class="ph ph-thumbs-up"></i>{{ $demand->votes_count }}</span>
            <span class="flex items-center gap-1 rounded-lg bg-slate-100 px-3 py-2" title="Interessados em ministrar"><i class="ph ph-chalkboard-teacher"></i>{{ $demand->teaching_interests_count }}</span>
        </div>
    </div>

    <p class="mt-4 line-clamp-3 text-sm leading-6 text-slate-600">{{ $demand->background }}</p>

    <div class="mt-5 flex flex-wrap gap-2">
        @if (! $viewer && ! $adminViewer)
            @if ($isOpen)
                <a href="{{ route('login', ['redirect' => $loginReturn]) }}" class="rounded-lg bg-[#0040A1] px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-900">Apoiar Demanda</a>
                <a href="{{ route('login', ['redirect' => $loginReturn]) }}" class="rounded-lg border border-[#0040A1] px-4 py-2 text-sm font-semibold text-[#0040A1] transition hover:bg-blue-50">Quero Ministrar</a>
            @else
                <span class="cursor-not-allowed rounded-lg bg-slate-200 px-4 py-2 text-sm font-semibold text-slate-500" title="Interações encerradas">Apoiar Demanda</span>
                <span class="cursor-not-allowed rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-400" title="Interações encerradas">Quero Ministrar</span>
            @endif
        @elseif ($viewer)
            @if ($isOpen && ! $isAuthor)
                <form method="POST" action="{{ $supported ? route('user.submissions.support.destroy', $demand->id) : route('user.submissions.support', $demand->id) }}">
                    @csrf
                    @if ($supported) @method('DELETE') @endif
                    <button class="rounded-lg bg-[#0040A1] px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-900">
                        {{ $supported ? 'Retirar Apoio' : 'Apoiar Demanda' }}
                    </button>
                </form>
            @else
                <span class="cursor-not-allowed rounded-lg bg-slate-200 px-4 py-2 text-sm font-semibold text-slate-500" title="{{ $isAuthor ? 'Você não pode apoiar a própria demanda' : 'Interações encerradas' }}">Apoiar Demanda</span>
            @endif

            @if ($isOpen && ($canTeach || $interested))
                <form method="POST" action="{{ $interested ? route('user.submissions.teaching-interest.destroy', $demand->id) : route('user.submissions.teaching-interest', $demand->id) }}">
                    @csrf
                    @if ($interested) @method('DELETE') @endif
                    <button class="rounded-lg border border-[#0040A1] px-4 py-2 text-sm font-semibold text-[#0040A1] transition hover:bg-blue-50">
                        {{ $interested ? 'Retirar Interesse' : 'Quero Ministrar' }}
                    </button>
                </form>
            @else
                <span class="cursor-not-allowed rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-400" title="{{ $isOpen ? 'Disponível para docentes e técnicos' : 'Interações encerradas' }}">Quero Ministrar</span>
            @endif
        @else
            <span class="cursor-not-allowed rounded-lg bg-slate-200 px-4 py-2 text-sm font-semibold text-slate-500" title="Disponível para usuários comuns">Apoiar Demanda</span>
            <span class="cursor-not-allowed rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-400" title="Disponível para usuários comuns">Quero Ministrar</span>
        @endif

        <a href="{{ route('demands.show', $demand->id) }}" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">Ver detalhes <i class="ph ph-arrow-right"></i></a>
    </div>
</article>
