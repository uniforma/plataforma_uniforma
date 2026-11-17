<x-admin-layout>
    <div class="p-4 sm:p-6">
        <x-header title="Propostas de ministração" description="Acompanhe as propostas enviadas e registre as decisões da coordenação." />

        @if ($errors->any())
            <div role="alert" class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.proposals.index') }}" method="GET" class="mb-4">
            <x-search name="search" placeholder="Pesquisar por submissão ou proponente...">
                <x-slot:filters>
                    <div class="grid gap-4 sm:grid-cols-[minmax(0,1fr)_auto] sm:items-end">
                        <x-select name="status" label="Situação">
                            <option value="">Todas</option>
                            @foreach (['pending' => 'Aguardando análise', 'needs_information' => 'Mais informações', 'approved' => 'Aprovada', 'rejected' => 'Recusada'] as $value => $label)
                                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                            @endforeach
                        </x-select>
                        <x-button href="{{ route('admin.proposals.index') }}" variant="secondary">Limpar filtros</x-button>
                    </div>
                </x-slot:filters>
            </x-search>
        </form>

        <x-table>
            <x-table.head>
                <x-table.th>Submissão</x-table.th>
                <x-table.th>Proponente</x-table.th>
                <x-table.th>Formato</x-table.th>
                <x-table.th>Modalidade</x-table.th>
                <x-table.th>Situação</x-table.th>
                <x-table.th>Enviada em</x-table.th>
                <x-table.th class="text-right">Ações</x-table.th>
            </x-table.head>
            <x-table.body>
                @forelse ($proposals as $proposal)
                    @php
                        $statusLabel = match ($proposal->status) {
                            'pending' => 'Aguardando análise',
                            'needs_information' => 'Mais informações',
                            'approved' => 'Aprovada',
                            'rejected' => 'Recusada',
                            default => $proposal->status,
                        };
                        $statusVariant = match ($proposal->status) {
                            'pending' => 'warning',
                            'needs_information' => 'info',
                            'approved' => 'success',
                            'rejected' => 'danger',
                            default => 'gray',
                        };
                    @endphp
                    <x-table.row>
                        <x-table.td><div class="max-w-56 truncate font-medium text-slate-900" title="{{ $proposal->submissao?->title }}">{{ $proposal->submissao?->title ?? 'Submissão removida' }}</div></x-table.td>
                        <x-table.td>{{ $proposal->user?->name ?? 'Usuário removido' }}</x-table.td>
                        <x-table.td>{{ ucfirst($proposal->type) }}</x-table.td>
                        <x-table.td>{{ match ($proposal->modality) { 'ead' => 'EAD', 'hibrido' => 'Híbrido', default => 'Presencial' } }}</x-table.td>
                        <x-table.td><x-badge :variant="$statusVariant">{{ $statusLabel }}</x-badge></x-table.td>
                        <x-table.td>{{ $proposal->created_at?->format('d/m/Y H:i') }}</x-table.td>
                        <x-table.td class="text-right"><x-button variant="view" size="sm" title="Ver proposta" x-on:click="$dispatch('open-modal', 'proposal-{{ $proposal->id }}')"><i class="ph ph-eye"></i></x-button></x-table.td>
                    </x-table.row>
                @empty
                    <x-table.row><x-table.td colspan="7" class="py-8 text-center text-slate-500">Nenhuma proposta encontrada.</x-table.td></x-table.row>
                @endforelse
            </x-table.body>
        </x-table>
        <x-pagination :paginator="$proposals" />

        @foreach ($proposals as $proposal)
            <x-modal name="proposal-{{ $proposal->id }}" maxWidth="xl" focusable>
                <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
                    <div class="flex items-start justify-between gap-4"><div><p class="text-xs font-bold uppercase tracking-wider text-primary-600">Proposta de ministração</p><h2 class="mt-1 text-xl font-bold text-slate-900">{{ $proposal->submissao?->title }}</h2></div><button type="button" x-on:click="$dispatch('close-modal', 'proposal-{{ $proposal->id }}')" class="rounded-lg p-1 text-slate-500 hover:bg-slate-100" aria-label="Fechar"><i class="ph ph-x text-xl"></i></button></div>
                    <p class="mt-2 text-sm text-slate-500">Enviada por {{ $proposal->user?->name ?? 'Usuário removido' }} em {{ $proposal->created_at?->format('d/m/Y H:i') }}</p>
                </div>
                <div class="max-h-[60vh] space-y-5 overflow-y-auto px-5 py-5 text-sm sm:px-6">
                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div><dt class="text-xs font-semibold uppercase text-slate-500">Tipo</dt><dd class="mt-1 font-medium">{{ ucfirst($proposal->type) }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase text-slate-500">Modalidade</dt><dd class="mt-1 font-medium">{{ match ($proposal->modality) { 'ead' => 'EAD', 'hibrido' => 'Híbrido', default => 'Presencial' } }}</dd></div>
                        <div><dt class="text-xs font-semibold uppercase text-slate-500">Carga horária</dt><dd class="mt-1 font-medium">{{ $proposal->workload_hours }} horas no total · {{ $proposal->hours_per_day }} horas por dia</dd></div>
                        <div><dt class="text-xs font-semibold uppercase text-slate-500">Dias da semana</dt><dd class="mt-1 font-medium">{{ implode(', ', array_map(fn ($day) => ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'][$day] ?? '—', $proposal->weekdays ?? [])) }}</dd></div>
                    </dl>
                    <div><p class="text-xs font-semibold uppercase text-slate-500">Recursos necessários</p><p class="mt-1 whitespace-pre-line leading-6 text-slate-700">{{ $proposal->resources }}</p></div>
                    @if ($proposal->review_notes)<div class="rounded-xl bg-slate-50 p-4"><p class="text-xs font-semibold uppercase text-slate-500">Justificativa da decisão</p><p class="mt-1 whitespace-pre-line text-slate-700">{{ $proposal->review_notes }}</p></div>@endif
                    @if ($proposal->status === 'pending')
                        <form method="POST" action="{{ route('admin.proposals.update', $proposal) }}" class="space-y-4 border-t border-slate-200 pt-5">
                            @csrf @method('PATCH')
                            <h3 class="font-bold text-slate-900">Registrar decisão</h3>
                            <x-select name="status" label="Decisão" required><option value="approved">Aprovar</option><option value="needs_information">Solicitar informações</option><option value="rejected">Recusar</option></x-select>
                            <div><label for="review-notes-{{ $proposal->id }}" class="mb-1 block font-medium text-slate-700">Justificativa <span class="font-normal text-slate-500">(obrigatória para recusa ou solicitação)</span></label><textarea id="review-notes-{{ $proposal->id }}" name="review_notes" rows="3" maxlength="5000" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-primary-500 focus:ring-primary-500"></textarea></div>
                            <div class="flex justify-end"><x-button type="submit"><i class="ph ph-check"></i> Confirmar decisão</x-button></div>
                        </form>
                    @endif
                </div>
            </x-modal>
        @endforeach
    </div>
</x-admin-layout>
