<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Submissao;


class UpdateUserSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        $submission = Submissao::find($this->route('submission'));

        return $submission 
            && $submission->autor_id === auth('user')->id() 
            && $submission->status->value === 'Em votação';
    }

    public function rules(): array
    {
      
        return [
            'title' => ['required', 'string', 'max:255'],
            'background' => ['required', 'string', 'min:10'],
            'knowledge_field' => ['required', 'string', 'max:100'],
        ];
    }
}
