@extends('layouts.user-layout')

@section('title', 'Minhas Demandas — UniForma')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold text-blue-700">Acompanhamento</p>
            <h1 class="mt-1 text-3xl font-bold text-slate-950">Minhas Demandas</h1>
            <p class="mt-2 text-slate-600">Acompanhe o andamento e o engajamento das suas propostas.</p>
        </div>
        <a href="{{ route('user.submissions.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0040A1] px-5 py-3 text-sm font-semibold text-white hover:bg-blue-900"><i class="ph ph-plus"></i> Nova Demanda</a>
    </div>

    <form method="GET" action="{{ route('user.submissions.index') }}" class="mt-8 grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:grid-cols-[1fr_220px_auto]">
        <input name="search" value="{{ request('search') }}" placeholder="Pesquisar pelo título..." class="rounded-lg border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-600 focus:ring-blue-600">
        <select name="status" class="rounded-lg border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-600 focus:ring-blue-600">
            <option value="">Todos os status</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
        <button class="rounded-lg bg-slate-800 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-950">Filtrar</button>
    </form>

    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr><th class="px-5 py-4">Demanda</th><th class="px-5 py-4">Status</th><th class="px-5 py-4">Apoios</th><th class="px-5 py-4">Interessados</th><th class="px-5 py-4">Criada em</th><th class="px-5 py-4 text-right">Ação</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($demands as $demand)
                        <tr>
                            <td class="px-5 py-4 font-semibold text-slate-900">{{ $demand->title }}</td>
                            <td class="px-5 py-4"><span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">{{ $demand->status->label() }}</span></td>
                            <td class="px-5 py-4">{{ $demand->votes_count }}</td>
                            <td class="px-5 py-4">{{ $demand->teaching_interests_count }}</td>
                            <td class="px-5 py-4 text-slate-500">{{ $demand->created_at?->format('d/m/Y') }}</td>
                           <td class="px-4 py-3 text-right sm:text-left">
    <div class="flex items-center gap-4">
        
        {{-- Visualizar Detalhes --}}
        <a href="{{ route('demands.show', $demand->id) }}" 
           class="text-[#0040A1] transition hover:text-blue-900" 
           title="Ver detalhes">
            <i class="ph ph-eye text-xl"></i>
        </a>

        {{-- Regra opcional: Só mostrar Editar/Excluir se estiver "Em votação" --}}
        @if ($demand->status->value === 'Em votação')
            
            {{-- Editar --}}
            <a href="{{ route('user.submissions.edit', $demand->id) }}" 
               class="text-slate-500 transition hover:text-amber-600" 
               title="Editar demanda">
                <i class="ph ph-pencil-simple text-xl"></i>
            </a>

            {{-- Excluir (Obrigatório usar <form> e método DELETE) --}}
            <form method="POST" action="{{ route('user.submissions.destroy', $demand->id) }}" 
                  onsubmit="return confirm('Tem certeza que deseja excluir esta demanda? Esta ação não pode ser desfeita.');" 
                  class="m-0 flex">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-slate-500 transition hover:text-red-600" title="Excluir demanda">
                    <i class="ph ph-trash text-xl"></i>
                </button>
            </form>

        @endif

    </div>
</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">Você ainda não criou nenhuma demanda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">{{ $demands->links() }}</div>
@endsection
