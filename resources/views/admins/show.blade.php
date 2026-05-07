<x-admin-layout>
    <div class="p-6">
        <x-header title="Administrador {{ $admin->name }}" description="Visualize os dados e as roles vinculadas a este administrador.">
            <x-slot name="actions">
                <x-button href="{{ route('admins.edit', $admin->id) }}" variant="edit">
                    <i class="ph ph-pencil text-lg"></i> Editar
                </x-button>
                <x-button href="{{ route('admins.index') }}" variant="outline">
                    <i class="ph ph-arrow-left text-lg"></i> Voltar
                </x-button>
            </x-slot>
        </x-header>

        <div class="grid gap-6 xl:grid-cols-3">
            <x-card class="xl:col-span-2">
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ID</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $admin->id }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $admin->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">E-mail</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $admin->email }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Criado em</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $admin->created_at?->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-200">Roles</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Roles atribuídas a este administrador.</p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @forelse ($admin->roles as $role)
                            <x-badge>{{ $role->name }}</x-badge>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma role atribuída.</p>
                        @endforelse
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-admin-layout>
