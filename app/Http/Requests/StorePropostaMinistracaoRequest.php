<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StorePropostaMinistracaoRequest extends FormRequest
{

    public function authorize(): bool
    {
        $user = auth('user')->user();

        return $user !== null
            && $user->roles()
                ->whereIn('name', ['docente', 'tecnico', 'servidor'])
                ->exists();
    }

    public function rules(): array
    {
        return [
            'carga_horaria' => ['required', 'integer', 'min:1', 'max:10000'],
            'dias_semana' => ['required', 'array', 'min:1'],
            'dias_semana.*' => [
                'required',
                'distinct',
                Rule::in([
                    'segunda', 'terca', 'quarta',
                    'quinta', 'sexta', 'sabado', 'domingo',
                ]),
            ],
            'horarios' => ['required', 'array', 'min:1'],
            'horarios.*' => ['required', 'array'],
            'horarios.*.inicio' => ['required', 'date_format:H:i'],
            'horarios.*.fim' => ['required', 'date_format:H:i'],
            'recursos' => ['nullable', 'string', 'max:5000'],
            'modalidade' => [
                'required',
                Rule::in(['EAD', 'HIBRIDO', 'PRESENCIAL']),
            ],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                $dias = $this->input('dias_semana');
                $horarios = $this->input('horarios');

                foreach ($horarios as $dia => $horario) {
                    if ($horario['fim'] <= $horario['inicio']) {
                        $validator->errors()->add(
                            "horarios.$dia.fim",
                            'O horário de término deve ser posterior ao horário de início.'
                        );
                    }
                }

                if (
                    array_diff($dias, array_keys($horarios)) ||
                    array_diff(array_keys($horarios), $dias)
                ) {
                    $validator->errors()->add(
                        'horarios',
                        'Informe um horário para cada dia selecionado.'
                    );
                }
            },
        ];
    }
}
