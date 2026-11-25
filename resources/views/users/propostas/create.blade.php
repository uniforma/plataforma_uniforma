<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

            <h1 class="text-2xl font-bold text-slate-900 mb-2">
                Proposta de Ministração
            </h1>

            <p class="text-slate-600 mb-6">
                Demanda: {{ $demanda->title }}
            </p>

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 p-4 text-red-700">
                    <p class="font-semibold mb-2">
                        Corrija os seguintes erros:
                    </p>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                id="form-proposta"
                method="POST"
                action="{{ route('user.propostas.store', $demanda->id) }}"
                class="text-slate-800"
            >
                @csrf

                <!-- Carga horária -->
                <div class="mb-6">
                    <label for="carga_horaria"
                           class="block font-semibold text-slate-800 mb-2">
                        Carga horária total
                    </label>

                    <input
                        id="carga_horaria"
                        type="number"
                        name="carga_horaria"
                        value="{{ old('carga_horaria') }}"
                        min="1"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white text-slate-900 placeholder-slate-400 focus:border-blue-600 focus:ring-blue-600"
                        placeholder="Ex.: 20"
                    >
                </div>

                @php
                    $dias = [
                        'segunda' => 'Segunda-feira',
                        'terca' => 'Terça-feira',
                        'quarta' => 'Quarta-feira',
                        'quinta' => 'Quinta-feira',
                        'sexta' => 'Sexta-feira',
                        'sabado' => 'Sábado',
                        'domingo' => 'Domingo'
                    ];
                @endphp

                <!-- Dias da semana -->
                <div class="mb-6">
                    <label class="block font-semibold text-slate-800 mb-3">
                        Dias da semana disponíveis
                    </label>

                    @foreach ($dias as $valor => $nome)
                        <div class="flex items-center gap-3 mb-3">
                            <input
                                type="checkbox"
                                name="dias_semana[]"
                                value="{{ $valor }}"
                                id="dia-{{ $valor }}"
                                onchange="atualizarHorarios()"
                                @checked(in_array($valor, old('dias_semana', [])))
                                class="rounded border-slate-400 bg-white text-blue-700 focus:ring-blue-600"
                            >

                            <label for="dia-{{ $valor }}"
                                   class="text-slate-800">
                                {{ $nome }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <!-- Horários -->
                <div class="mb-6">
                    <h2 class="font-semibold text-slate-800 mb-3">
                        Horários disponíveis
                    </h2>

                    @foreach ($dias as $valor => $nome)
                        <div
                            id="horario-{{ $valor }}"
                            class="horario-dia hidden mb-4 rounded-lg bg-slate-50 border border-slate-200 p-4"
                        >
                            <p class="font-medium text-slate-800 mb-2">
                                {{ $nome }}
                            </p>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-1 text-slate-700">
                                        Início
                                    </label>

                                    <input
                                        type="time"
                                        name="horarios[{{ $valor }}][inicio]"
                                        value="{{ old('horarios.' . $valor . '.inicio') }}"
                                        class="w-full rounded-lg border border-slate-300 bg-white text-slate-900 focus:border-blue-600 focus:ring-blue-600"
                                        disabled
                                    >
                                </div>

                                <div>
                                    <label class="block mb-1 text-slate-700">
                                        Fim
                                    </label>

                                    <input
                                        type="time"
                                        name="horarios[{{ $valor }}][fim]"
                                        value="{{ old('horarios.' . $valor . '.fim') }}"
                                        class="w-full rounded-lg border border-slate-300 bg-white text-slate-900 focus:border-blue-600 focus:ring-blue-600"
                                        disabled
                                    >
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Recursos -->
                <div class="mb-6">
                    <label for="recursos"
                           class="block font-semibold text-slate-800 mb-2">
                        Recursos necessários
                    </label>

                    <textarea
                        id="recursos"
                        name="recursos"
                        rows="4"
                        class="w-full rounded-lg border border-slate-300 bg-white text-slate-900 placeholder-slate-400 focus:border-blue-600 focus:ring-blue-600"
                        placeholder="Ex.: projetor, computadores, internet..."
                    >{{ old('recursos') }}</textarea>
                </div>

                <!-- Modalidade -->
                <div class="mb-6">
                    <label for="modalidade"
                           class="block font-semibold text-slate-800 mb-2">
                        Modalidade
                    </label>

                    <select
                        id="modalidade"
                        name="modalidade"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white text-slate-900 focus:border-blue-600 focus:ring-blue-600"
                    >
                        <option value="">Selecione</option>
                        <option value="EAD" @selected(old('modalidade') === 'EAD')>
                            EAD
                        </option>
                        <option value="HIBRIDO" @selected(old('modalidade') === 'HIBRIDO')>
                            Híbrido
                        </option>
                        <option value="PRESENCIAL" @selected(old('modalidade') === 'PRESENCIAL')>
                            Presencial
                        </option>
                    </select>
                </div>

                <!-- Botões -->
                <div class="flex justify-end gap-3">
                    <a
                        href="{{ route('demands.show', $demanda->id) }}"
                        class="rounded-lg border border-slate-300 bg-white px-5 py-3 text-slate-700 hover:bg-slate-100 transition"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="rounded-lg bg-[#0040A1] px-6 py-3 font-semibold text-white transition hover:bg-blue-800"
                    >
                        Enviar proposta
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function atualizarHorarios() {
            document.querySelectorAll('.horario-dia').forEach(function (bloco) {
                const dia = bloco.id.replace('horario-', '');
                const checkbox = document.getElementById('dia-' + dia);
                const selecionado = checkbox.checked;

                bloco.classList.toggle('hidden', !selecionado);

                bloco.querySelectorAll('input').forEach(function (input) {
                    input.disabled = !selecionado;
                    input.required = selecionado;
                });
            });
        }

        document.addEventListener('DOMContentLoaded', atualizarHorarios);
    </script>
</x-app-layout>