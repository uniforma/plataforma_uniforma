<x-admin-layout>
    <div class="p-6">
        <x-header title="Permissões" description="Visualize as permissões do sistema.">
        </x-header>

        <div class="mb-4">
            <form action="{{ route('permissions.index') }}" method="GET">
                <x-search name="search" placeholder="Pesquisar permissões..." />
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <x-table>
                <x-table.head>
                    <x-table.th>ID</x-table.th>
                    <x-table.th>Nome</x-table.th>
                    <x-table.th class="text-right">Ações</x-table.th>
                </x-table.head>

                <x-table.body>
                    @forelse($permissions as $permission)
                        <x-table.row>
                            <x-table.td>{{ $permission->id }}</x-table.td>
                            <x-table.td>{{ $permission->description }}</x-table.td>
                            <x-table.td class="text-right space-x-2">
                                <x-button href="{{ route('permissions.show', $permission->id) }}" variant="view">
                                    <i class="ph ph-eye text-lg"></i>
                                </x-button>
                            </x-table.td>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.td colspan="3" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                Nenhuma permissão encontrada.
                            </x-table.td>
                        </x-table.row>
                    @endforelse
                </x-table.body>
            </x-table>
        </div>

        @if (method_exists($permissions, 'links'))
            <x-pagination :paginator="$permissions" />
        @endif
    </div>
</x-admin-layout>
