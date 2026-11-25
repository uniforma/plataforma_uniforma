<x-guest-layout>
    <div class="mb-7"><p class="text-xs font-bold uppercase tracking-widest text-primary-500">Bem-vindo de volta</p><h1 class="mt-2 text-3xl font-bold text-slate-950">Entre na UniForma</h1><p class="mt-2 text-sm text-slate-600">Acesse sua conta e continue participando.</p></div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <x-input name="email" label="{{ __('Email') }}" type="email" :value="old('email')" required autofocus
            autocomplete="username" :messages="$errors->get('email')" />

        <!-- Password -->
        <x-input name="password" label="{{ __('Password') }}" type="password" required autocomplete="current-password"
            :messages="$errors->get('password')" />

        @if (Route::has('password.request'))
            <a class="hover:underline text-xs pl-1 text-gray-600 hover:text-gray-900   rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
        @endif

        <x-button type="submit" class="w-full">
            Entrar
        </x-button>

        <x-divider>Não possui conta?</x-divider>

        <x-button variant="outline" href="{{ route('register') }}" class="w-full">
            Registrar
        </x-button>
    </form>
</x-guest-layout>
