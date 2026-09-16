<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('user')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'background' => ['required', 'string', 'min:20', 'max:5000'],
            'target_audience' => ['required', 'string', 'max:255'],
            'knowledge_field' => ['required', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'título',
            'background' => 'contexto',
            'target_audience' => 'público-alvo',
            'knowledge_field' => 'área do conhecimento',
        ];
    }
}
