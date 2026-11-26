@extends('layouts.user-layout')

@section('title', 'Submissões aprovadas')

@section('content')
    <div class="space-y-6">
        <section class="rounded-3xl bg-white p-6 shadow-sm sm:p-8">
            <h1 class="text-3xl font-bold text-slate-950">Submissões aprovadas</h1>
            <p class="mt-3 text-slate-600">
                Conheça as demandas da comunidade acadêmica que foram oficializadas.
            </p>
        </section>

        <form method="GET" action="{{ route('submissions.approved') }}"
              class="rounded-2xl bg-white p-6 shadow-sm">
            <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">
                Buscar por título
            </label>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <input id="search" name="search" type="search" maxlength="255"
                       value="{{ $search }}"
                       placeholder="Digite o título da demanda"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">

                <button type="submit"
                        class="rounded-xl bg-[#0040A1] px-5 py-3 text-sm font-semibold text-white hover:bg-blue-900">
                    Buscar
                </button>

                @if ($search !== '')
                    <a href="{{ route('submissions.approved') }}"
                       class="whitespace-nowrap text-sm font-semibold text-[#0040A1]">
                        Limpar busca
                    </a>
                @endif
            </div>
        </form>

        <div class="grid gap-5">
            @forelse ($approvedDemands as $demand)
                @include('users.partials.demand-card', ['demand' => $demand])
            @empty
                <p class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600">
                    {{ $search === ''
                        ? 'Ainda não há submissões aprovadas.'
                        : 'Nenhuma submissão aprovada corresponde à sua busca.' }}
                </p>
            @endforelse
        </div>

        {{ $approvedDemands->links() }}
    </div>
@endsection