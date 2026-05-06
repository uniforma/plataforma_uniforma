<x-admin-layout>
    <div class="p-6">
        <x-header title="{{ $permission->description }}" description="Visualize as informações e as permissões atreladas a este perfil.">
            <x-slot name="actions">
                <x-button href="{{ route('permissions.index') }}" variant="outline">
                    <i class="ph ph-arrow-left text-lg"></i> Voltar
                </x-button>
            </x-slot>
        </x-header>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informações Básicas</h3>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">ID da Permissão</p>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $permission->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome</p>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $permission->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Descrição</p>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $permission->description }}</p>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Usuários com esta Permissão ({{ $permission->users->count() }})</h3>
                
                @if($permission->users->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($permission->users->take(10) as $user)
                            <span class="inline-flex items-center px-3 py-1 rounded border border-gray-300 text-sm font-medium text-gray-700 bg-white dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                                {{ $user->name }}
                            </span>
                        @endforeach
                        @if($permission->users->count() > 10)
                            <span class="inline-flex items-center px-3 py-1 rounded border border-gray-300 text-sm font-medium text-gray-500 bg-gray-50 dark:bg-gray-700 dark:text-gray-400 dark:border-gray-600">
                                +{{ $permission->users->count() - 10 }} outros
                            </span>
                        @endif
                    </div>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum usuário possui esta permissão atualmente.</p>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>