<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\ValidCpf;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->has('cpf')) {
            $this->merge(['cpf' => ValidCpf::digits($this->input('cpf'))]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];

        if (auth('user')->check()) {
            $rules += [
                'skills' => ['required', 'array', 'min:1', 'max:20'],
                'skills.*' => ['required', 'string', 'max:80', 'distinct:ignore_case'],
                'knowledge_areas' => ['required', 'array', 'min:1', 'max:20'],
                'knowledge_areas.*' => ['required', 'string', 'max:80', 'distinct:ignore_case'],
                'recommendation_emails_enabled' => ['sometimes', 'boolean'],
                'cpf' => ['required', new ValidCpf, Rule::unique('users', 'cpf')->ignore($this->user()->id)],
                'gender' => ['required', Rule::in(['feminino', 'masculino', 'nao_binario', 'outro', 'nao_informar'])],
            ];
        }

        return $rules;
    }
}
