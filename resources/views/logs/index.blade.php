<x-admin-layout>
    <div class="p-6">
        <x-header title="Logs" description="Visualize os logs do sistema." />

        <form action="{{ route('logs.index') }}" method="GET" class="mb-4">
            <x-search name="search" placeholder="Pesquisar logs...">
                <x-slot name="filters">
                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label for="event" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Event</label>
                            <select
                                id="event"
                                name="event"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-white/10 dark:bg-surface-800 dark:text-gray-100"
                            >
                                <option value="">Todos</option>
                                @foreach (['created', 'updated', 'deleted', 'restored', 'enabled', 'disabled'] as $event)
                                    <option value="{{ $event }}" @selected(request('event') === $event)>{{ $event }}</option>
                                @endforeach
                            </select>
                        </div>

                        <x-input
                            name="created_from"
                            label="Criado de"
                            type="date"
                            :value="request('created_from')"
                        />

                        <x-input
                            name="created_to"
                            label="Criado até"
                            type="date"
                            :value="request('created_to')"
                        />
                    </div>
                </x-slot>
            </x-search>
        </form>

        <x-table>
            <x-table.head>
                <x-table.th>Event</x-table.th>
                <x-table.th>Descrição</x-table.th>
                <x-table.th>Usuário</x-table.th>
                <x-table.th>Criado em</x-table.th>
                <x-table.th class="text-right">Ações</x-table.th>
            </x-table.head>

            <x-table.body>
                @forelse ($logs as $log)
                    <x-table.row>
                        <x-table.td>
                            @php
                                $eventVariant = match ($log->event) {
                                    'created' => 'success',
                                    'updated' => 'warning',
                                    'deleted' => 'danger',
                                    'restored' => 'gray',
                                    default => 'info',
                                };
                            @endphp
                            <x-badge :variant="$eventVariant">{{ $log->event }}</x-badge>
                        </x-table.td>
                        <x-table.td>{{ $log->description }}</x-table.td>
                        <x-table.td>{{ $log->user?->name ?? '-' }}</x-table.td>
                        <x-table.td>{{ $log->created_at?->format('d/m/Y H:i:s') }}</x-table.td>
                        <x-table.td class="text-right">
                            <x-button href="{{ route('logs.show', $log->id) }}" variant="view">
                                <i class="ph ph-eye text-lg"></i>
                            </x-button>
                        </x-table.td>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">
                            Nenhum log encontrado.
                        </x-table.td>
                    </x-table.row>
                @endforelse
            </x-table.body>
        </x-table>

        @if (method_exists($logs, 'links'))
            <x-pagination :paginator="$logs" />
        @endif
    </div>
</x-admin-layout>
