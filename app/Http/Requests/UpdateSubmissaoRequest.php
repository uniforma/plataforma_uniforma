<?php

namespace App\Http\Requests;

use App\Enums\SubmissaoStatus;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateSubmissaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(SubmissaoStatus::class)],
            'curator_id' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            $requiresCurator = in_array($this->input('status'), [
                SubmissaoStatus::EmCuradoria->value,
                SubmissaoStatus::Oficializado->value,
            ], true);

            if ($requiresCurator && ! $this->filled('curator_id')) {
                $validator->errors()->add('curator_id', 'Selecione um curador para este status.');
            }

            if ($this->filled('curator_id')) {
                $isAdmin = User::query()
                    ->whereKey($this->integer('curator_id'))
                    ->whereHas('roles', fn ($query) => $query->where('guard_name', 'admin'))
                    ->exists();

                if (! $isAdmin) {
                    $validator->errors()->add('curator_id', 'O curador deve ser um administrador ativo.');
                }
            }
        }];
    }
}
