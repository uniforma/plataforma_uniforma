<x-admin-layout>
    <div class="p-6">
        <x-header title="Usuários" description="Gerencie os usuários e seus perfis institucionais.">
            <x-slot name="actions">
                @can('create_users')
                    <x-button href="{{ route('users.create') }}"><i class="ph ph-plus"></i> Adicionar</x-button>
                @endcan
            </x-slot>
        </x-header>

        <form action="{{ route('users.index') }}" method="GET" class="mb-4">
            <x-search name="search" placeholder="Pesquisar por nome ou e-mail...">
                <x-slot name="filters">
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
                        <div>
                            <label for="role" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Perfil</label>
                            <select id="role" name="role" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                                <option value="">Todos</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" @selected(request('role') === $role->name)>{{ match($role->name) { 'discente' => 'Discente', 'docente' => 'Docente', 'tecnico' => 'Técnico', default => ucfirst($role->name) } }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="date_from" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Criado a partir de</label>
                            <input id="date_from" name="date_from" type="date" value="{{ request('date_from') }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                        </div>
                        <div>
                            <label for="date_to" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Criado até</label>
                            <input id="date_to" name="date_to" type="date" value="{{ request('date_to') }}" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                        </div>
                        <div>
                            <label for="trash" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Situação</label>
                            <select id="trash" name="trash" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                                <option value="active" @selected(request('trash', 'active') === 'active')>Ativos</option>
                                <option value="trashed" @selected(request('trash') === 'trashed')>Lixeira</option>
                                <option value="all" @selected(request('trash') === 'all')>Todos</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <x-button href="{{ route('users.index') }}" variant="secondary" class="w-full">Limpar filtros</x-button>
                        </div>
                    </div>
                </x-slot>
            </x-search>
        </form>

        <x-table>
            <x-table.head>
                <x-table.th>Nome</x-table.th>
                <x-table.th>E-mail</x-table.th>
                <x-table.th>Perfil</x-table.th>
                <x-table.th>Submissões</x-table.th>
                <x-table.th>Criado em</x-table.th>
                <x-table.th class="text-right">Ações</x-table.th>
            </x-table.head>
            <x-table.body>
                @forelse ($users as $user)
                    <x-table.row class="{{ $user->trashed() ? 'opacity-70' : '' }}">
                        <x-table.td>
                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                            @if ($user->trashed())<x-badge>Na lixeira</x-badge>@endif
                        </x-table.td>
                        <x-table.td>{{ $user->email }}</x-table.td>
                        <x-table.td>
                            @php($roleName = $user->roles->first()?->name)
                            <x-badge>{{ match($roleName) { 'discente' => 'Discente', 'docente' => 'Docente', 'tecnico' => 'Técnico', default => $roleName ?? 'Sem perfil' } }}</x-badge>
                        </x-table.td>
                        <x-table.td>{{ $user->submissoes_count }}</x-table.td>
                        <x-table.td>{{ $user->created_at?->format('d/m/Y H:i') }}</x-table.td>
                        <x-table.td class="text-right space-x-2">
                            <x-button href="{{ route('users.show', $user->id) }}" variant="view" size="sm"><i class="ph ph-eye"></i></x-button>
                            @if ($user->trashed())
                                @can('restore_users')
                                    <form method="POST" action="{{ route('users.restore', $user->id) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <x-button type="submit" variant="outline" size="sm" title="Restaurar"><i class="ph ph-arrow-counter-clockwise"></i></x-button>
                                    </form>
                                @endcan
                                @can('force_delete_users')
                                    <x-button variant="danger" size="sm" x-on:click="$dispatch('set-action', { name: 'force-user-deletion', action: '{{ route('users.force-delete', $user->id) }}' }); $dispatch('open-modal', 'force-user-deletion')"><i class="ph ph-trash"></i></x-button>
                                @endcan
                            @else
                                @can('edit_users')<x-button href="{{ route('users.edit', $user->id) }}" variant="edit" size="sm"><i class="ph ph-pencil"></i></x-button>@endcan
                                @can('delete_users')
                                    <x-button variant="danger" size="sm" x-on:click="$dispatch('set-action', { name: 'user-deletion', action: '{{ route('users.destroy', $user->id) }}' }); $dispatch('open-modal', 'user-deletion')"><i class="ph ph-trash"></i></x-button>
                                @endcan
                            @endif
                        </x-table.td>
                    </x-table.row>
                @empty
                    <x-table.row><x-table.td colspan="6" class="py-6 text-center text-gray-500">Nenhum usuário encontrado.</x-table.td></x-table.row>
                @endforelse
            </x-table.body>
        </x-table>
        <x-pagination :paginator="$users" />
    </div>

    <x-modal-delete name="user-deletion" action="" title="Mover usuário para a lixeira" message="O usuário perderá o acesso, mas poderá ser restaurado posteriormente." />
    <x-modal-delete name="force-user-deletion" action="" title="Excluir usuário definitivamente" message="Esta ação é permanente e não poderá ser desfeita." />
</x-admin-layout>
