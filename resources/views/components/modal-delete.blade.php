@props([
    'name',
    'title' => 'Confirmar Exclusão',
    'message' => 'Tem certeza que deseja excluir este registro? Essa ação não poderá ser desfeita.',
    'action',
])

<x-modal :name="$name" focusable>
    <form method="post" :action="actionUrl" x-data="{ actionUrl: '{{ $action }}' }"
        @set-action.window="if($event.detail.name === '{{ $name }}') actionUrl = $event.detail.action"
        class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ $title }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ $message }}
        </p>

        <div class="mt-6 flex justify-end gap-3">
            <x-button x-on:click="$dispatch('close')" type="button" variant="secondary">
                {{ __('Cancelar') }}
            </x-button>

            <x-button type="submit" variant="danger">
                {{ __('Excluir') }}
            </x-button>
        </div>
    </form>
</x-modal>
