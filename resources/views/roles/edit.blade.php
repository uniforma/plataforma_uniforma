<x-admin-layout>
    <div class="p-6">
        <x-header title="Editar Perfil" description="Altere o nome e as permissões atreladas a este perfil.">
            <x-slot name="actions">
                <x-button href="{{ route('roles.index') }}" variant="outline">
                    <i class="ph ph-arrow-left text-lg"></i> Voltar
                </x-button>
            </x-slot>
        </x-header>

        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-card>
                <div class="space-y-8">
                    <div class="space-y-3">
                        <x-input name="name" label="Nome do Cargo" type="text" :value="old('name', $role->name)" required
                            autofocus autocomplete="off" :messages="$errors->get('name')" :disabled="$role->id === 1" />
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h4
                                class="text-sm font-medium tracking-wide text-gray-600 dark:text-white transition-colors">
                                Permissões</h4>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">As permissões definem o que esse
                                cargo pode ver e executar.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
                            @foreach ($permissions as $permission)
                                <x-checkbox name="permissions[]" :value="$permission->name" :checked="in_array(
                                    $permission->name,
                                    old('permissions', $role->permissions->pluck('name')->toArray()),
                                )" :label="$permission->description"
                                    :description="$permission->name" :disabled="$role->id === 1" />
                            @endforeach
                        </div>
                    </div>
                </div>

                <x-slot name="footer">
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <x-button href="{{ route('roles.index') }}" variant="secondary">
                            Cancelar
                        </x-button>

                        <x-button type="submit">
                            Atualizar cargo
                        </x-button>
                    </div>
                </x-slot>
            </x-card>
        </form>
    </div>
</x-admin-layout>
