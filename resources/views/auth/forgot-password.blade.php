<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
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
</x-guest-layout>
