<x-admin-layout>
    <div class="p-6">
        <x-header title="Submissões" description="Acompanhe o fluxo, a curadoria e o engajamento das submissões." />

        <form action="{{ route('submissions.index') }}" method="GET" class="mb-4">
            <x-search name="search" placeholder="Pesquisar título, conteúdo, autor ou curador...">
                <x-slot name="filters">
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">
                        <div>
                            <label for="status" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                            <select id="status" name="status" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                                <option value="">Todos</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="curator_id" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Curador</label>
                            <select id="curator_id" name="curator_id" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                                <option value="">Todos</option>
                                @foreach ($curators as $curator)
                                    <option value="{{ $curator->id }}" @selected((string) request('curator_id') === (string) $curator->id)>{{ $curator->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="date_from" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Criada a partir de</label>
                            <input id="date_from" name="date_from" type="date" value="{{ request('date_from') }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                        </div>
                        <div>
                            <label for="date_to" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Criada até</label>
                            <input id="date_to" name="date_to" type="date" value="{{ request('date_to') }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                        </div>
                        <div>
                            <label for="trash" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Situação</label>
                            <select id="trash" name="trash" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                                <option value="active" @selected(request('trash', 'active') === 'active')>Ativas</option>
                                <option value="trashed" @selected(request('trash') === 'trashed')>Lixeira</option>
                                <option value="all" @selected(request('trash') === 'all')>Todas</option>
                            </select>
                        </div>
                        <div class="flex items-end"><x-button href="{{ route('submissions.index') }}" variant="secondary" class="w-full">Limpar filtros</x-button></div>
                    </div>
                </x-slot>
            </x-search>
        </form>

        <x-table>
            <x-table.head>
                <x-table.th>Título</x-table.th>
                <x-table.th>Autor</x-table.th>
                <x-table.th>Curador</x-table.th>
                <x-table.th>Status</x-table.th>
                <x-table.th>Votos</x-table.th>
                <x-table.th>Interessados</x-table.th>
                <x-table.th>Criada em</x-table.th>
                <x-table.th class="text-right">Ações</x-table.th>
            </x-table.head>
            <x-table.body>
                @forelse ($submissions as $submission)
                    <x-table.row class="{{ $submission->trashed() ? 'opacity-70' : '' }}">
                        <x-table.td>
                            <div class="max-w-xs truncate font-medium text-gray-900 dark:text-gray-100" title="{{ $submission->title }}">{{ $submission->title }}</div>
                            @if ($submission->trashed())<x-badge>Na lixeira</x-badge>@endif
                        </x-table.td>
                        <x-table.td>{{ $submission->autor?->name ?? 'Autor removido' }}</x-table.td>
                        <x-table.td>{{ $submission->curador?->name ?? 'Não atribuído' }}</x-table.td>
                        <x-table.td><x-badge>{{ $submission->status->label() }}</x-badge></x-table.td>
                        <x-table.td>{{ $submission->votes_count }}</x-table.td>
                        <x-table.td>{{ $submission->teaching_interests_count }}</x-table.td>
                        <x-table.td>{{ $submission->created_at?->format('d/m/Y H:i') }}</x-table.td>
                        <x-table.td class="text-right space-x-2">
                            <x-button href="{{ route('submissions.show', $submission->id) }}" variant="view" size="sm"><i class="ph ph-eye"></i></x-button>
                            @if ($submission->trashed())
                                @can('restore_submissoes')
                                    <form method="POST" action="{{ route('submissions.restore', $submission->id) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <x-button type="submit" variant="outline" size="sm" title="Restaurar"><i class="ph ph-arrow-counter-clockwise"></i></x-button>
                                    </form>
                                @endcan
                                @can('force_delete_submissoes')
                                    <x-button variant="danger" size="sm" x-on:click="$dispatch('set-action', { name: 'force-submission-deletion', action: '{{ route('submissions.force-delete', $submission->id) }}' }); $dispatch('open-modal', 'force-submission-deletion')"><i class="ph ph-trash"></i></x-button>
                                @endcan
                            @else
                                @can('edit_submissoes')<x-button href="{{ route('submissions.edit', $submission->id) }}" variant="edit" size="sm"><i class="ph ph-pencil"></i></x-button>@endcan
                                @can('delete_submissoes')
                                    <x-button variant="danger" size="sm" x-on:click="$dispatch('set-action', { name: 'submission-deletion', action: '{{ route('submissions.destroy', $submission->id) }}' }); $dispatch('open-modal', 'submission-deletion')"><i class="ph ph-trash"></i></x-button>
                                @endcan
                            @endif
                        </x-table.td>
                    </x-table.row>
                @empty
                    <x-table.row><x-table.td colspan="8" class="py-6 text-center text-gray-500">Nenhuma submissão encontrada.</x-table.td></x-table.row>
                @endforelse
            </x-table.body>
        </x-table>
        <x-pagination :paginator="$submissions" />
    </div>

    <x-modal-delete name="submission-deletion" action="" title="Mover submissão para a lixeira" message="A submissão deixará de aparecer nas consultas comuns, mas poderá ser restaurada." />
    <x-modal-delete name="force-submission-deletion" action="" title="Excluir submissão definitivamente" message="A submissão e seus dados serão removidos permanentemente." />
</x-admin-layout>
