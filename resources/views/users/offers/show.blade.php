@extends('layouts.user-layout')

@section('content')
    @php($proposal = $submissao->approvedProposal)

    <div class="mx-auto max-w-3xl px-4 py-8">
        <a href="{{ route('offers.index') }}" class="font-semibold text-blue-700">
            Voltar para formações
        </a>

        <article class="mt-5 rounded-xl border border-slate-200 bg-white p-6">
            <p class="text-sm text-slate-600">
                {{ \App\Models\TeachingInterest::TYPES[$proposal->type] }}
            </p>

            <h1 class="mt-1 text-2xl font-bold text-slate-900">{{ $submissao->title }}</h1>
            <p class="mt-4 whitespace-pre-line text-slate-700">{{ $submissao->background }}</p>

            <dl class="my-6 grid gap-4 sm:grid-cols-2">
                <div>
                    <dt class="font-semibold">Modalidade</dt>
                    <dd>{{ match ($proposal->modalidade) {
                        'EAD' => 'EAD',
                        'HIBRIDO' => 'Híbrido',
                        'PRESENCIAL' => 'Presencial',
                        default => 'A definir',
                    } }}</dd>
                </div>

                <div>
                    <dt class="font-semibold">Carga horária</dt>
                    <dd>{{ $proposal->carga_horaria }} horas</dd>
                </div>

                <div>
                    <dt class="font-semibold">Ministrante</dt>
                    <dd>{{ $proposal->user?->name ?? 'Ministrante não informado' }}</dd>
                </div>

                <div>
                    <dt class="font-semibold">Horários propostos</dt>
                    @forelse ($proposal->horarios ?? [] as $day => $hours)
                        <dd>{{ ucfirst($day) }} · {{ $hours['inicio'] }} às {{ $hours['fim'] }}</dd>
                    @empty
                        <dd>Horários a confirmar</dd>
                    @endforelse
                </div>
            </dl>

            <section class="border-t border-slate-200 pt-5" aria-labelledby="registration-heading">
                <h2 id="registration-heading" class="mb-3 text-lg font-bold">Inscrição</h2>

                @if ($registered)
                    <p role="status" class="font-semibold text-green-800">
                        Inscrição confirmada.
                    </p>
                @elseif ($user)
                    <form method="POST" action="{{ route('user.registrations.store', $submissao) }}">
                        @csrf
                        <p class="mb-4 text-slate-700">{{ $user->name }} · {{ $user->email }}</p>
                        <x-button type="submit">Confirmar inscrição</x-button>
                    </form>
                @else
                    <x-button href="{{ route('login', ['redirect' => route('offers.show', $submissao, false)]) }}">
                        Entrar para se inscrever
                    </x-button>
                @endif
            </section>
        </article>
    </div>
@endsection