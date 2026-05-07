<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "string", "email", "max:255", Rule::unique("users", "email")],
            "roles" => ["required", "array", "min:1"],
            "roles.*" => [Rule::exists("roles", "name")->where(fn ($query) => $query->where("guard_name", "admin"))],
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "O nome é obrigatório.",
            "name.string" => "O nome deve ser um texto.",
            "name.max" => "O nome não pode ter mais de 255 caracteres.",
            "email.required" => "O e-mail é obrigatório.",
            "email.email" => "O e-mail deve ser um endereço válido.",
            "email.unique" => "Este e-mail já está cadastrado no sistema.",
            "email.max" => "O e-mail não pode ter mais de 255 caracteres.",
            "roles.required" => "Selecione pelo menos uma role.",
            "roles.array" => "As roles devem ser um array.",
            "roles.min" => "Selecione pelo menos uma role.",
            "roles.*.exists" => "Uma ou mais roles selecionadas não existem no sistema.",
        ];
    }
}
