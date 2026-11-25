<x-card>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 ">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 ">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route($profileRoutePrefix . '.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input
                name="name"
                label="{{ __('Name') }}"
                type="text"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
                :messages="$errors->get('name')"
            />
        </div>

        <div>
            <x-input
                name="email"
                label="{{ __('Email') }}"
                type="email"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
                :messages="$errors->get('email')"
            />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 ">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600  hover:text-gray-900  rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 ">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if ($profileRoutePrefix === 'user.profile')
            <x-input name="cpf" label="CPF" type="text" :value="old('cpf', $user->cpf)" required maxlength="14" inputmode="numeric" placeholder="000.000.000-00" :messages="$errors->get('cpf')" />
            <label class="block text-sm font-semibold text-slate-700">Gênero
                <x-select name="gender" required class="mt-2 w-full rounded-xl border-slate-300">
                    @foreach (['feminino' => 'Feminino', 'masculino' => 'Masculino', 'nao_binario' => 'Não binário', 'outro' => 'Outro', 'nao_informar' => 'Prefiro não informar'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('gender', $user->gender) === $value)>{{ $label }}</option>
                    @endforeach
                </x-select>
            </label>
            @error('gender')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            <x-tag-input name="skills" label="Habilidades" kind="skill" :values="$user->skills ?? []" />
            <x-tag-input name="knowledge_areas" label="Áreas de conhecimento" kind="area" :values="$user->knowledge_areas ?? []" />
            <label class="flex items-start gap-3 rounded-xl bg-slate-50 p-4 text-sm text-slate-700">
                <input type="hidden" name="recommendation_emails_enabled" value="0">
                <input type="checkbox" name="recommendation_emails_enabled" value="1" @checked(old('recommendation_emails_enabled', $user->recommendation_emails_enabled)) class="mt-1 rounded border-slate-300 text-primary-500 focus:ring-primary-500">
                Permitir receber e-mails de recomendações de submissões para ministrar
            </label>
        @endif

        <div class="flex items-center gap-4">
            <x-button type="submit">{{ __('Save') }}</x-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 "
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
</x-card>
