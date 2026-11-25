<x-guest-layout>
    <div class="mb-6"><p class="text-xs font-bold uppercase tracking-widest text-primary-500">Acesso à conta</p><h1 class="mt-2 text-3xl font-bold text-slate-950">Recuperar senha</h1></div>
    <div class="mb-4 text-sm text-gray-600 ">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-3">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input name="email" label="{{ __('Email') }}" type="email" :value="old('email')" required autofocus
                :messages="$errors->get('email')" />
        </div>

        <x-button class="w-full" type="submit">
            {{ __('Email Password Reset Link') }}
        </x-button>
    </form>
    <a href="{{ route('login') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-primary-600 hover:underline"><i class="ph ph-arrow-left"></i> Voltar ao login</a>
</x-guest-layout>
