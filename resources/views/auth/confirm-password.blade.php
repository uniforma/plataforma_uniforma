<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input 
                name="password" 
                label="{{ __('Password') }}" 
                type="password" 
                required 
                autocomplete="current-password" 
                :messages="$errors->get('password')" 
            />
        </div>

        <div class="flex justify-end mt-4">
            <x-button>
                {{ __('Confirm') }}
            </x-button>
        </div>
    </form>
</x-guest-layout>
