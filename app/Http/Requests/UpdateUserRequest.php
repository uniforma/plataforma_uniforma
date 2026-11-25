<?php

namespace App\Http\Requests;

use App\Rules\ValidCpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge(['cpf' => ValidCpf::digits($this->input('cpf'))]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'role' => ['required', 'string', Rule::in(['aluno', 'servidor'])],
            'cpf' => ['required', new ValidCpf, Rule::unique('users', 'cpf')->ignore($this->route('user'))],
            'gender' => ['required', Rule::in(['feminino', 'masculino', 'nao_binario', 'outro', 'nao_informar'])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado no sistema.',
            'role.required' => 'Selecione um perfil.',
            'role.exists' => 'O perfil selecionado é inválido.',
        ];
    }
}
