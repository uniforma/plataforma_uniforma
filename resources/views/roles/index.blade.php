<x-admin-layout>
    <div class="p-6">
        <x-header title="Perfis" description="Gerencie os perfis do sistema.">
            <x-slot name="actions">
            <x-button href="{{ route('roles.create') }}" variant="primary">
                    <i class="ph ph-plus"></i>Adicionar
                </x-button>
            </x-slot>
        </x-header>

        <div class="mb-4">
            <form action="{{ route('roles.index') }}" method="GET">
                <x-search name="search" placeholder="Pesquisar perfis..." />
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
                    @forelse($roles as $role)
                        <x-table.row>
                            <x-table.td>{{ $role->id }}</x-table.td>
                            <x-table.td class="uppercase">{{ $role->name }}</x-table.td>
                            <x-table.td class="text-right space-x-2">
                                <x-button href="{{ route('roles.show', $role->id) }}" variant="view">
                                    <i class="ph ph-eye text-lg"></i>
                                </x-button>
                                <x-button href="{{ route('roles.edit', $role->id) }}" variant="edit">
                                    <i class="ph ph-pencil text-lg"></i>
                                </x-button>
                                @if(($role->id !== 1) && ($role->id !== 2)) <!-- Evita exclusão do cargo de administrador e user normal -->
                                    <x-button variant="danger" onclick="confirmDeletion('{{ route('roles.destroy', $role->id) }}')">
                                        <i class="ph ph-trash text-lg"></i>
                                    </x-button>
                                @endif
                            </x-table.td>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.td colspan="3" class="text-center py-4 text-gray-500 dark:text-gray-400">
                                Nenhum cargo encontrado.
                            </x-table.td>
                        </x-table.row>
                    @endforelse
                </x-table.body>
            </x-table>
        </div>

        @if(method_exists($roles, 'links'))
            <x-pagination :paginator="$roles" />
        @endif
    </div>

    <x-modal-delete name="confirm-role-deletion" action="" title="Excluir Cargo" message="Você tem certeza que deseja excluir este cargo? Todos os usuários ligados a este cargo podem perder seus acessos." />
</x-admin-layout>
