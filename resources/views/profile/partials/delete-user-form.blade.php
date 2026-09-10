<x-card>
<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Ao excluir sua conta, seu acesso será desativado. Um administrador ainda poderá restaurá-la antes de uma exclusão definitiva.
        </p>
    </header>

    <x-button
        variant="danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route($profileRoutePrefix . '.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Sua conta será desativada. Informe sua senha para confirmar.
            </p>

            <div class="mt-6">
                <x-input 
                    id="password"
                    name="password" 
                    label="{{ __('Password') }}" 
                    type="password" 
                    placeholder="{{ __('Password') }}"
                    :messages="$errors->userDeletion->get('password')" 
                />
            </div>

            <div class="mt-6 flex justify-end">
                <x-button variant="secondary" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-button>

                <x-button type="submit" variant="danger" class="ms-3">
                    {{ __('Delete Account') }}
                </x-button>
            </div>
        </form>
    </x-modal>
</section>
</x-card>
