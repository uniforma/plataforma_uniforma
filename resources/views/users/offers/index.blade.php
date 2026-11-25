@extends('layouts.user-layout')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-8">
        <h1 class="mb-6 text-2xl font-bold text-slate-900">Formações aprovadas</h1>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($offers as $offer)
                <article class="rounded-xl border border-slate-200 bg-white p-6">
                    <p class="text-sm text-slate-600">
                        {{ \App\Models\TeachingInterest::TYPES[$offer->approvedProposal->type] }}
                    </p>

                    <h2 class="mb-4 mt-1 text-lg font-bold text-slate-900">
                        {{ $offer->title }}
                    </h2>

                    <x-button href="{{ route('offers.show', $offer) }}">
                        Ver formação e inscrição
                    </x-button>
                </article>
            @empty
                <p class="text-slate-600">Nenhuma formação com inscrições abertas.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $offers->links() }}
        </div>
    </div>
@endsection