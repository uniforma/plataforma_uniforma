<x-admin-layout>
    <div class="p-6">
        <x-header title="Criar Administrador" description="Cadastre um novo administrador e selecione as roles de acesso.">
            <x-slot name="actions">
                <x-button href="{{ route('admins.index') }}" variant="outline">
                    <i class="ph ph-arrow-left text-lg"></i> Voltar
                </x-button>
            </x-slot>
        </x-header>

        <form action="{{ route('admins.store') }}" method="POST">
            @csrf

            <x-card>
                <div class="space-y-8">
                    <div class="grid gap-6 md:grid-cols-2">
                        <x-input
                            name="name"
                            label="Nome"
                            type="text"
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="off"
                            :messages="$errors->get('name')"
                        />

                        <x-input
                            name="email"
                            label="E-mail"
                            type="email"
                            :value="old('email')"
                            required
                            autocomplete="email"
                            :messages="$errors->get('email')"
                        />
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-200">Roles</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Selecione uma ou mais roles para este administrador. Um e-mail de definição de senha será enviado após o cadastro.</p>
                                                @if($errors->has('roles'))
                                                    <div class="rounded-lg border border-red-300 bg-red-50 p-3 dark:border-red-900/50 dark:bg-red-900/20">
                                                        <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ $errors->first('roles') }}</p>
                                                    </div>
                                                @endif

                        </div>

                        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                            @foreach ($roles as $role)
                                <x-checkbox
                                    name="roles[]"
                                    :value="$role->name"
                                    :checked="in_array($role->name, old('roles', []))"
                                    :label="$role->name"
                                    :description="$role->description ?? 'Acesso ao perfil ' . $role->name"
                                />
                            @endforeach
                        </div>
                    </div>
                </div>

                <x-slot name="footer">
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                        <x-button href="{{ route('admins.index') }}" variant="secondary">
                            Cancelar
                        </x-button>
                        <x-button type="submit">
                            Salvar administrador
                        </x-button>
                    </div>
                </x-slot>
            </x-card>
        </form>
    </div>
</x-admin-layout>
