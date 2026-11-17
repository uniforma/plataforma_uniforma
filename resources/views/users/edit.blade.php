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
                    <x-input name="cpf" label="CPF" :value="old('cpf', $user->cpf)" required maxlength="14" inputmode="numeric" placeholder="000.000.000-00" :messages="$errors->get('cpf')" />
                    <label>Gênero <x-select name="gender" required class="mt-1 w-full rounded-xl border-slate-300">@foreach (['feminino' => 'Feminino', 'masculino' => 'Masculino', 'nao_binario' => 'Não binário', 'outro' => 'Outro', 'nao_informar' => 'Prefiro não informar'] as $value => $label)<option value="{{ $value }}" @selected(old('gender', $user->gender) === $value)>{{ $label }}</option>@endforeach</x-select></label>
                    <div>
                        <label for="role" class="mb-1 block text-sm font-medium text-gray-700 ">Perfil</label>
                        <x-select id="role" name="role" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500   ">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected(old('role', $user->roles->first()?->name) === $role->name)>{{ match($role->name) { 'aluno' => 'Aluno', 'servidor' => 'Servidor', default => ucfirst($role->name) } }}</option>
                            @endforeach
                        </x-select>
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
