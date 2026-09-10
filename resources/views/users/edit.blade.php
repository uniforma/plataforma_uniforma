<x-admin-layout>
    <div class="p-6">
        <x-header title="Editar Usuário" description="Atualize os dados e o perfil institucional.">
            <x-slot name="actions">
                <x-button href="{{ route('users.show', $user->id) }}" variant="outline"><i class="ph ph-eye"></i> Visualizar</x-button>
                <x-button href="{{ route('users.index') }}" variant="secondary">Voltar</x-button>
            </x-slot>
        </x-header>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <x-card>
                <div class="grid gap-6 md:grid-cols-2">
                    <x-input name="name" label="Nome" :value="old('name', $user->name)" required autofocus :messages="$errors->get('name')" />
                    <x-input name="email" label="E-mail" type="email" :value="old('email', $user->email)" required :messages="$errors->get('email')" />
                    <div>
                        <label for="role" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Perfil</label>
                        <select id="role" name="role" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected(old('role', $user->roles->first()?->name) === $role->name)>{{ match($role->name) { 'discente' => 'Discente', 'docente' => 'Docente', 'tecnico' => 'Técnico', default => ucfirst($role->name) } }}</option>
                            @endforeach
                        </select>
                        @error('role')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <x-slot name="footer">
                    <div class="flex justify-end gap-3">
                        <x-button href="{{ route('users.index') }}" variant="secondary">Cancelar</x-button>
                        <x-button type="submit">Atualizar usuário</x-button>
                    </div>
                </x-slot>
            </x-card>
        </form>
    </div>
</x-admin-layout>
