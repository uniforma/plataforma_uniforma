<x-guest-layout>
    <div class="mb-6">
        <p class="text-xs font-bold uppercase tracking-widest text-primary-500">Faça parte da UniForma</p>
        <h1 class="mt-2 text-3xl font-bold text-slate-950">Crie sua conta</h1>
        <p class="mt-2 text-sm text-slate-600">Compartilhe conhecimentos e participe das demandas da comunidade.</p>
    </div>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        <x-input name="name" label="Nome completo" type="text" :value="old('name')" required autofocus autocomplete="name" :messages="$errors->get('name')" />
        <x-input name="email" label="E-mail" type="email" :value="old('email')" required autocomplete="email" :messages="$errors->get('email')" />
        <x-input name="cpf" label="CPF" type="text" :value="old('cpf')" required maxlength="14" inputmode="numeric" autocomplete="off" placeholder="000.000.000-00" :messages="$errors->get('cpf')" />
        <label class="block text-sm font-semibold text-slate-700">Gênero
            <x-select name="gender" required class="mt-2 w-full rounded-xl border-slate-300">
                <option value="">Selecione</option>
                @foreach (['feminino' => 'Feminino', 'masculino' => 'Masculino', 'nao_binario' => 'Não binário', 'outro' => 'Outro', 'nao_informar' => 'Prefiro não informar'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('gender') === $value)>{{ $label }}</option>
                @endforeach
            </x-select>
        </label>
        @error('gender')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        <fieldset>
            <legend class="mb-2 text-sm font-semibold text-slate-700">Perfil <span class="text-red-600">*</span></legend>
            <div class="grid grid-cols-2 gap-3">
                @foreach (['aluno' => 'Aluno', 'servidor' => 'Servidor'] as $value => $label)
                    <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-300 bg-white p-3 text-sm font-semibold text-slate-700 has-checked:border-primary-500 has-checked:bg-primary-50">
                        <input type="radio" name="role" value="{{ $value }}" @checked(old('role', 'aluno') === $value) required class="text-primary-500 focus:ring-primary-500">{{ $label }}
                    </label>
                @endforeach
            </div>
            @error('role')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </fieldset>
        <x-tag-input name="skills" label="Habilidades" kind="skill" />
        <x-tag-input name="knowledge_areas" label="Áreas de conhecimento" kind="area" />
        <x-input name="password" label="Senha" type="password" required autocomplete="new-password" :messages="$errors->get('password')" />
        <x-input name="password_confirmation" label="Confirme a senha" type="password" required autocomplete="new-password" :messages="$errors->get('password_confirmation')" />
        <label class="flex items-start gap-3 rounded-xl bg-slate-50 p-4 text-sm leading-6 text-slate-700">
            <input type="hidden" name="recommendation_emails_enabled" value="0">
            <input type="checkbox" name="recommendation_emails_enabled" value="1" @checked(old('recommendation_emails_enabled')) class="mt-1 rounded border-slate-300 text-primary-500 focus:ring-primary-500">
            Permitir receber e-mails de recomendações de submissões para ministrar
        </label>
        <x-button type="submit" class="w-full">Criar conta</x-button>
        <p class="text-center text-sm text-slate-600">Já possui conta? <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:underline">Entrar</a></p>
    </form>
</x-guest-layout>
