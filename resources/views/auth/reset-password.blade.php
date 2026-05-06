<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" class="space-y-3">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <x-input name="email" label="{{ __('Email') }}" type="email" :value="old('email', $request->email)" required autofocus
            autocomplete="username" :messages="$errors->get('email')" />

        <!-- Password -->
        <x-input name="password" label="{{ __('Password') }}" type="password" required autocomplete="new-password"
            :messages="$errors->get('password')" />

        <!-- Confirm Password -->
        <x-input name="password_confirmation" label="{{ __('Confirm Password') }}" type="password" required
            autocomplete="new-password" :messages="$errors->get('password_confirmation')" />

        <x-button type="submit" class="w-full">
            {{ __('Reset Password') }}
        </x-button>
    </form>
</x-guest-layout>
