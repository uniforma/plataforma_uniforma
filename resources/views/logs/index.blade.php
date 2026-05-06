<x-admin-layout>
    <div class="p-6">
        <x-header title="Logs" description="Visualize os logs do sistema.">
        </x-header>

        <div class="mb-4">
            <form action="{{ route('logs.index') }}" method="GET">
                <x-search name="search" placeholder="Pesquisar logs..." />
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <x-table>
                <x-table.head>
                    <x-table.th>Event</x-table.th>
                    <x-table.th>Nome</x-table.th>
                    <x-table.th class="text-right">Ações</x-table.th>
                </x-table.head>

                <x-table.body>
                    @forelse($logs as $log)
                        <x-table.row>
                            <x-table.td>{{ $log->event }}</x-table.td>
                            <x-table.td>{{ $log->name }}</x-table.td>
                            <x-table.td class="text-right space-x-2">
                                <x-button href="{{ route('logs.show', $log->id) }}" variant="view">
                                    <i class="ph ph-eye text-lg"></i>
                                </x-button>
                            </x-table.td>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.td colspan="3" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                Nenhum log encontrado.
                            </x-table.td>
                        </x-table.row>
                    @endforelse
                </x-table.body>
            </x-table>
        </div>

        @if (method_exists($logs, 'links'))
            <x-pagination :paginator="$logs" />
        @endif
    </div>
</x-admin-layout>
