<x-admin-layout>
    <div class="space-y-6 p-4 sm:p-6">
        <x-header
            title="Propostas de ministração"
            description="Analise as propostas enviadas e registre a decisão da coordenação."
        />

        @if (session('status'))
            <p role="status" class="rounded-lg bg-green-50 p-3 text-green-800">
                {{ session('status') }}
            </p>
        @endif

        @if ($errors->any())
            <ul role="alert" class="list-inside list-disc rounded-lg bg-red-50 p-3 text-red-800">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form method="GET" action="{{ route('admin.proposals.index') }}" class="flex flex-wrap items-end gap-3">
            <label class="block">
                Pesquisar
                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Submissão ou proponente"
                    class="mt-1 block rounded-lg border-slate-300"
                >
            </label>

            <label class="block">
                Situação
                <select name="status" class="mt-1 block rounded-lg border-slate-300 bg-white text-slate-900">
                    <option value="">Todas</option>
                    @foreach ([
                        'pending' => 'Aguardando análise',
                        'needs_information' => 'Mais informações solicitadas',
                        'approved' => 'Aprovada',
                        'rejected' => 'Recusada',
                    ] as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </label>

            <x-button type="submit">Filtrar</x-button>
        </form>

        @forelse ($proposals as $proposal)
            <article class="space-y-4 rounded-xl border border-slate-200 bg-white p-5 text-slate-900">
                <div>
                    <h2 class="text-lg font-bold">{{ $proposal->submissao->title }}</h2>
                    <p class="text-sm text-slate-600">
                        Proponente: {{ $proposal->user?->name ?? 'Usuário removido' }}
                    </p>
                    <p class="text-sm text-slate-600">
                        {{ match ($proposal->status) {
                            'pending' => 'Aguardando análise',
                            'needs_information' => 'Mais informações solicitadas',
                            'approved' => 'Aprovada',
                            'rejected' => 'Recusada',
                            default => $proposal->status,
                        } }}
                    </p>
                </div>

                <dl class="grid gap-3 text-sm sm:grid-cols-2">
                    <div>
                        <dt class="font-semibold">Formato</dt>
                        <dd>{{ \App\Models\TeachingInterest::TYPES[$proposal->type] ?? 'A definir' }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold">Modalidade</dt>
                        <dd>{{ match ($proposal->modalidade) {
                            'EAD' => 'EAD',
                            'HIBRIDO' => 'Híbrido',
                            'PRESENCIAL' => 'Presencial',
                            default => 'A definir',
                        } }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold">Carga horária</dt>
                        <dd>{{ $proposal->carga_horaria }} horas</dd>
                    </div>
                    <div>
                        <dt class="font-semibold">Horários disponíveis</dt>
                        @forelse ($proposal->horarios ?? [] as $day => $hours)
                            <dd>{{ ucfirst($day) }} · {{ $hours['inicio'] }} às {{ $hours['fim'] }}</dd>
                        @empty
                            <dd>Sem horários informados</dd>
                        @endforelse
                    </div>
                    <div>
                        <dt class="font-semibold">Recursos</dt>
                        <dd class="whitespace-pre-line">{{ $proposal->recursos ?: 'Sem recursos informados' }}</dd>
                    </div>
                    @if ($proposal->review_notes)
                        <div>
                            <dt class="font-semibold">Justificativa da decisão</dt>
                            <dd class="whitespace-pre-line">{{ $proposal->review_notes }}</dd>
                        </div>
                    @endif
                </dl>

                @if (
                    in_array($proposal->status, ['pending', 'needs_information'], true)
                    && $proposal->submissao->status !== \App\Enums\SubmissaoStatus::Arquivado
                )
                    <form
                        method="POST"
                        action="{{ route('admin.proposals.update', $proposal) }}"
                        class="space-y-4 border-t border-slate-200 pt-4"
                    >
                        @csrf
                        @method('PATCH')

                        <label class="block">
                            Decisão
                            <select name="status" required class="mt-1 block rounded-lg border-slate-300 bg-white text-slate-900">
                                <option value="">Selecione</option>
                                <option value="approved">Aprovar</option>
                                <option value="needs_information">Solicitar informações</option>
                                <option value="rejected">Recusar</option>
                            </select>
                        </label>

                        <label class="block">
                            Formato da formação (obrigatório para aprovação)
                            <select name="type" class="mt-1 block rounded-lg border-slate-300 bg-white text-slate-900">
                                <option value="">Selecione</option>
                                @foreach (\App\Models\TeachingInterest::TYPES as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block">
                            Justificativa (obrigatória para recusa ou solicitação de informações)
                            <textarea
                                name="review_notes"
                                rows="3"
                                maxlength="5000"
                                class="mt-1 block w-full rounded-lg border-slate-300 bg-white text-slate-900"
                            ></textarea>
                        </label>

                        <x-button type="submit">Confirmar decisão</x-button>
                    </form>
                @endif
            </article>
        @empty
            <p class="text-slate-600">Nenhuma proposta encontrada.</p>
        @endforelse

        {{ $proposals->links() }}
    </div>
</x-admin-layout>