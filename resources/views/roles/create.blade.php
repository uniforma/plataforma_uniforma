<x-admin-layout>
    <div class="p-6">
        <x-header title="Criar Novo Cargo" description="Defina um novo cargo e escolha quais permissões ele possui.">
            <x-slot name="actions">
                <x-button href="{{ route('roles.index') }}" variant="secondary">
                    Voltar
                </x-button>
            </x-slot>
        </x-header>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <x-card>
                <x-slot name="header">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do cargo</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Escolha um nome claro e selecione exatamente o conjunto de acessos necessários.</p>
                    </div>
                </x-slot>

                <div class="space-y-8">
                    <x-input
                        name="name"
                        label="Nome do Cargo"
                        type="text"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="off"
                        :messages="$errors->get('name')"
                    />

                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-200">Permissões</h4>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Marque os acessos que este cargo poderá usar no sistema.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
                            @foreach($permissions as $permission)
                                <x-checkbox
                                    name="permissions[]"
                                    :value="$permission->name"
                                    :checked="in_array($permission->name, old('permissions', []))"
                                    :label="$permission->name"
                                    :description="'Acesso ao recurso ' . $permission->name"
                                />
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
                            Salvar cargo
                        </x-button>
                    </div>
                </x-slot>
            </x-card>
        </form>
    </div>
</x-admin-layout>