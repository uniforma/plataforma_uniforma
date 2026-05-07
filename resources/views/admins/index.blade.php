<x-admin-layout>
    <div class="p-6">
        <x-header title="Administradores" description="Gerencie os administradores do sistema.">
            <x-slot name="actions">
                <x-button href="{{ route('admins.create') }}" variant="primary">
                    <i class="ph ph-plus"></i> Adicionar
                </x-button>
            </x-slot>
        </x-header>

        <form action="{{ route('admins.index') }}" method="GET" class="mb-4">
            <x-search name="search" placeholder="Pesquisar administradores...">
                <x-slot name="filters">
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        <div>
                            <label for="role" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Role</label>
                            <select
                                id="role"
                                name="role"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-white/10 dark:bg-surface-800 dark:text-gray-100"
                            >
                                <option value="">Todas as roles</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" @selected(request('role') === $role->name)>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </x-slot>
            </x-search>
        </form>

        <x-table>
            <x-table.head>
                <x-table.th>ID</x-table.th>
                <x-table.th>Nome</x-table.th>
                <x-table.th>Email</x-table.th>
                <x-table.th>Roles</x-table.th>
                <x-table.th>Criado em</x-table.th>
                <x-table.th class="text-right">Ações</x-table.th>
            </x-table.head>

            <x-table.body>
                @forelse ($admins as $admin)
                    <x-table.row>
                        <x-table.td>{{ $admin->id }}</x-table.td>
                        <x-table.td class="font-medium text-gray-900 dark:text-gray-100">{{ $admin->name }}</x-table.td>
                        <x-table.td>{{ $admin->email }}</x-table.td>
                        <x-table.td>
                            <div class="flex flex-wrap gap-2">
                                @forelse ($admin->roles as $role)
                                    <x-badge>{{ $role->name }}</x-badge>
                                @empty
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Sem role</span>
                                @endforelse
                            </div>
                        </x-table.td>
                        <x-table.td>{{ $admin->created_at?->format('d/m/Y H:i') }}</x-table.td>
                        <x-table.td class="text-right space-x-2">
                            <x-button href="{{ route('admins.show', $admin->id) }}" variant="view">
                                <i class="ph ph-eye text-lg"></i>
                            </x-button>
                            <x-button href="{{ route('admins.edit', $admin->id) }}" variant="edit">
                                <i class="ph ph-pencil text-lg"></i>
                            </x-button>
                        </x-table.td>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.td colspan="6" class="py-4 text-center text-gray-500 dark:text-gray-400">
                            Nenhum administrador encontrado.
                        </x-table.td>
                    </x-table.row>
                @endforelse
            </x-table.body>
        </x-table>

        @if (method_exists($admins, 'links'))
            <x-pagination :paginator="$admins" />
        @endif
    </div>
</x-admin-layout>
