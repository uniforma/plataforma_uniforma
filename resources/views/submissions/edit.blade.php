<x-admin-layout>
    <div class="p-6">
        <x-header title="Gerenciar fluxo" description="{{ $submission->title }}">
            <x-slot name="actions">
                <x-button href="{{ route('submissions.show', $submission->id) }}" variant="outline"><i class="ph ph-eye"></i> Visualizar</x-button>
                <x-button href="{{ route('submissions.index') }}" variant="secondary">Voltar</x-button>
            </x-slot>
        </x-header>

        <form action="{{ route('submissions.update', $submission->id) }}" method="POST">
            @csrf @method('PUT')
            <x-card>
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="status" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                        <select id="status" name="status" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}" @selected(old('status', $submission->status->value) === $status->value)>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                        @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="curator_id" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-200">Curador</label>
                        <select id="curator_id" name="curator_id" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm dark:border-white/10 dark:bg-surface-800 dark:text-gray-100">
                            <option value="">Não atribuído</option>
                            @foreach ($curators as $curator)
                                <option value="{{ $curator->id }}" @selected((string) old('curator_id', $submission->curator_id) === (string) $curator->id)>{{ $curator->name }} — {{ $curator->email }}</option>
                            @endforeach
                        </select>
                        @error('curator_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        <p class="mt-2 text-xs text-gray-500">Obrigatório para “Em curadoria” e “Oficializado”.</p>
                    </div>
                </div>
                <div class="mt-8 rounded-lg border border-gray-200 p-4 dark:border-white/10">
                    <p class="text-sm font-medium text-gray-500">Conteúdo original</p>
                    <p class="mt-2 font-semibold dark:text-gray-100">{{ $submission->title }}</p>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $submission->background }}</p>
                </div>
                <x-slot name="footer">
                    <div class="flex justify-end gap-3">
                        <x-button href="{{ route('submissions.index') }}" variant="secondary">Cancelar</x-button>
                        <x-button type="submit">Salvar fluxo</x-button>
                    </div>
                </x-slot>
            </x-card>
        </form>
    </div>
</x-admin-layout>
