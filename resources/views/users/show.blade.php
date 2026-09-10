<x-admin-layout>
    <div class="p-6">
        <x-header title="{{ $user->name }}" description="Dados e atividade do usuário.">
            <x-slot name="actions">
                @if (! $user->trashed())
                    @can('edit_users')<x-button href="{{ route('users.edit', $user->id) }}" variant="edit"><i class="ph ph-pencil"></i> Editar</x-button>@endcan
                @endif
                <x-button href="{{ route('users.index', $user->trashed() ? ['trash' => 'trashed'] : []) }}" variant="outline"><i class="ph ph-arrow-left"></i> Voltar</x-button>
            </x-slot>
        </x-header>

        <div class="grid gap-6 xl:grid-cols-3">
            <x-card class="xl:col-span-2">
                <div class="grid gap-6 md:grid-cols-2">
                    <div><p class="text-sm text-gray-500">Nome</p><p class="mt-1 font-semibold dark:text-gray-100">{{ $user->name }}</p></div>
                    <div><p class="text-sm text-gray-500">E-mail</p><p class="mt-1 font-semibold dark:text-gray-100">{{ $user->email }}</p></div>
                    <div><p class="text-sm text-gray-500">E-mail verificado</p><p class="mt-1 font-semibold dark:text-gray-100">{{ $user->email_verified_at?->format('d/m/Y H:i') ?? 'Não verificado' }}</p></div>
                    <div><p class="text-sm text-gray-500">Criado em</p><p class="mt-1 font-semibold dark:text-gray-100">{{ $user->created_at?->format('d/m/Y H:i') }}</p></div>
                    <div><p class="text-sm text-gray-500">Situação</p><div class="mt-1"><x-badge>{{ $user->trashed() ? 'Na lixeira' : 'Ativo' }}</x-badge></div></div>
                    <div><p class="text-sm text-gray-500">Submissões</p><p class="mt-1 font-semibold dark:text-gray-100">{{ $user->submissoes_count }}</p></div>
                </div>
            </x-card>
            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wide dark:text-gray-100">Perfil institucional</h3>
                <div class="mt-4">
                    @php($roleName = $user->roles->first()?->name)
                    <x-badge>{{ match($roleName) { 'discente' => 'Discente', 'docente' => 'Docente', 'tecnico' => 'Técnico', default => $roleName ?? 'Sem perfil' } }}</x-badge>
                </div>
            </x-card>
        </div>
    </div>
</x-admin-layout>
