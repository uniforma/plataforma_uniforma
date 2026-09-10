<x-admin-layout>
    <div class="p-6">
        <x-header title="Criar Usuário" description="Cadastre um usuário e defina seu perfil institucional.">
            <x-slot name="actions">
                <x-button href="{{ route('users.index') }}" variant="outline"><i class="ph ph-arrow-left"></i> Voltar</x-button>
            </x-slot>
        </x-header>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <x-card>
                <div class="grid gap-6 md:grid-cols-2">
                    <x-input name="name" label="Nome" :value="old('name')" required autofocus :messages="$errors->get('name')" />
                    <x-input name="email" label="E-mail" type="email" :value="old('email')" required :messages="$errors->get('email')" />
                    <div>
                        <label for="role" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Perfil</label>
                        <select id="role" name="role" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                            <option value="">Selecione um perfil</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected(old('role') === $role->name)>{{ match($role->name) { 'discente' => 'Discente', 'docente' => 'Docente', 'tecnico' => 'Técnico', default => ucfirst($role->name) } }}</option>
                            @endforeach
                        </select>
                        @error('role')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">O usuário receberá um e-mail para definir sua senha.</p>
                <x-slot name="footer">
                    <div class="flex justify-end gap-3">
                        <x-button href="{{ route('users.index') }}" variant="secondary">Cancelar</x-button>
                        <x-button type="submit">Salvar usuário</x-button>
                    </div>
                </x-slot>
            </x-card>
        </form>
    </div>
</x-admin-layout>
