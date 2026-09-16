<x-admin-layout>
    <div class="p-6">
        <x-header title="{{ $submission->title }}" description="Detalhes e acompanhamento da submissão.">
            <x-slot name="actions">
                @if (! $submission->trashed())
                    @can('edit_submissoes')<x-button href="{{ route('submissions.edit', $submission->id) }}" variant="edit"><i class="ph ph-pencil"></i> Gerenciar fluxo</x-button>@endcan
                @endif
                <x-button href="{{ route('submissions.index', $submission->trashed() ? ['trash' => 'trashed'] : []) }}" variant="outline"><i class="ph ph-arrow-left"></i> Voltar</x-button>
            </x-slot>
        </x-header>

        <div class="grid gap-6 xl:grid-cols-3">
            <x-card class="xl:col-span-2">
                <div class="space-y-6">
                    <div><p class="text-sm font-medium text-gray-500">Contexto</p><p class="mt-2 whitespace-pre-line text-gray-900 dark:text-gray-100">{{ $submission->background }}</p></div>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div><p class="text-sm font-medium text-gray-500">Público-alvo</p><p class="mt-1 dark:text-gray-100">{{ $submission->target_audience }}</p></div>
                        <div><p class="text-sm font-medium text-gray-500">Área do conhecimento</p><p class="mt-1 dark:text-gray-100">{{ $submission->knowledge_field }}</p></div>
                        <div><p class="text-sm font-medium text-gray-500">Autor</p><p class="mt-1 dark:text-gray-100">{{ $submission->autor?->name ?? 'Autor removido' }}</p></div>
                        <div><p class="text-sm font-medium text-gray-500">Criada em</p><p class="mt-1 dark:text-gray-100">{{ $submission->created_at?->format('d/m/Y H:i') }}</p></div>
                    </div>
                </div>
            </x-card>
            <x-card>
                <div class="space-y-5">
                    <div><p class="text-sm font-medium text-gray-500">Status</p><div class="mt-1"><x-badge>{{ $submission->status->label() }}</x-badge></div></div>
                    <div><p class="text-sm font-medium text-gray-500">Curador</p><p class="mt-1 font-semibold dark:text-gray-100">{{ $submission->curador?->name ?? 'Não atribuído' }}</p></div>
                    <div><p class="text-sm font-medium text-gray-500">Votos</p><p class="mt-1 text-2xl font-bold dark:text-gray-100">{{ $submission->votes_count }}</p></div>
                    <div><p class="text-sm font-medium text-gray-500">Interessados em ministrar</p><p class="mt-1 text-2xl font-bold dark:text-gray-100">{{ $submission->teaching_interests_count }}</p></div>
                    <div><p class="text-sm font-medium text-gray-500">Situação</p><div class="mt-1"><x-badge>{{ $submission->trashed() ? 'Na lixeira' : 'Ativa' }}</x-badge></div></div>
                </div>
            </x-card>
        </div>

        <x-card class="mt-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Interessados em ministrar</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Esta lista é visível somente no painel administrativo.</p>
            <div class="mt-5 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-white/10">
                    <thead><tr class="text-left text-xs uppercase tracking-wide text-gray-500"><th class="px-3 py-2">Nome</th><th class="px-3 py-2">E-mail</th><th class="px-3 py-2">Perfil</th><th class="px-3 py-2">Registrado em</th></tr></thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @forelse ($submission->teachingInterests as $interest)
                            <tr>
                                <td class="px-3 py-3 font-medium dark:text-gray-100">{{ $interest->user?->name ?? 'Usuário removido' }}</td>
                                <td class="px-3 py-3 dark:text-gray-300">{{ $interest->user?->email ?? '—' }}</td>
                                <td class="px-3 py-3"><x-badge>{{ match($interest->user?->roles->first()?->name) { 'docente' => 'Docente', 'tecnico' => 'Técnico', 'discente' => 'Discente', default => 'Sem perfil' } }}</x-badge></td>
                                <td class="px-3 py-3 dark:text-gray-300">{{ $interest->created_at?->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-3 py-6 text-center text-gray-500">Nenhum usuário demonstrou interesse.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</x-admin-layout>
