<x-admin-layout>
    <div class="p-6">
        <x-header title="Log #{{ $log->id }}" description="Detalhes do evento registrado pelo sistema.">
            <x-slot name="actions">
                <x-button href="{{ route('logs.index') }}" variant="outline">
                    <i class="ph ph-arrow-left text-lg"></i> Voltar
                </x-button>
            </x-slot>
        </x-header>

        <div class="grid gap-6 xl:grid-cols-3">
            <x-card class="xl:col-span-2">
                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Evento</p>
                        <div class="mt-1">
                            @php
                                $eventVariant = match ($log->event) {
                                    'created' => 'success',
                                    'updated' => 'warning',
                                    'deleted' => 'danger',
                                    'restored' => 'gray',
                                    default => 'info',
                                };
                            @endphp
                            <x-badge :variant="$eventVariant">{{ $log->event }}</x-badge>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Log Name</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $log->log_name }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Descrição</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $log->description }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Criado em</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $log->created_at?->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Subject</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $log->subject_type ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Subject ID</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $log->subject_id ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Usuário</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $log->user?->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">E-mail</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $log->user?->email ?? '-' }}</p>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-200">Propriedades</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Payload bruto do evento registrado.</p>
                    </div>

                    <pre class="overflow-x-auto rounded-lg bg-surface-950 p-4 text-xs leading-6 text-gray-100">{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                </div>
            </x-card>
        </div>
    </div>
</x-admin-layout>
