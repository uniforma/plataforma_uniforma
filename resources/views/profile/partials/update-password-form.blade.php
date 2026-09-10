<x-card>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input 
                id="update_password_current_password"
                name="current_password" 
                label="{{ __('Current Password') }}" 
                type="password" 
                autocomplete="current-password" 
                :messages="$errors->updatePassword->get('current_password')" 
            />
        </div>

        <div>
            <x-input 
                id="update_password_password"
                name="password" 
                label="{{ __('New Password') }}" 
                type="password" 
                autocomplete="new-password" 
                :messages="$errors->updatePassword->get('password')" 
            />
        </div>

        <div>
            <x-input 
                id="update_password_password_confirmation"
                name="password_confirmation" 
                label="{{ __('Confirm Password') }}" 
                type="password" 
                autocomplete="new-password" 
                :messages="$errors->updatePassword->get('password_confirmation')" 
            />
        </div>

        <div class="flex items-center gap-4">
            <x-button type="submit">{{ __('Save') }}</x-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
</x-card>
