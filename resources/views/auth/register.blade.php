<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input 
                name="name" 
                label="{{ __('Name') }}" 
                type="text" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name" 
                :messages="$errors->get('name')" 
            />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input 
                name="email" 
                label="{{ __('Email') }}" 
                type="email" 
                :value="old('email')" 
                required 
                autocomplete="username" 
                :messages="$errors->get('email')" 
            />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input 
                name="password" 
                label="{{ __('Password') }}" 
                type="password" 
                required 
                autocomplete="new-password" 
                :messages="$errors->get('password')" 
            />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input 
                name="password_confirmation" 
                label="{{ __('Confirm Password') }}" 
                type="password" 
                required 
                autocomplete="new-password" 
                :messages="$errors->get('password_confirmation')" 
            />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-button class="ms-4" type="submit">
                {{ __('Register') }}
            </x-button>
        </div>
    </form>
</x-guest-layout>
