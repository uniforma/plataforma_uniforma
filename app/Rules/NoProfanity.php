<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class NoProfanity implements ValidationRule
{
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail
    ): void {

        $palavroes = config('profanity.words');

        $texto = Str::lower(
            Str::ascii($value)
        );

        foreach ($palavroes as $palavra) {

            $palavra = Str::lower(
                Str::ascii($palavra)
            );

            if (preg_match(
                '/\b' . preg_quote($palavra, '/') . '\b/i',
                $texto
            )) {
                $fail(
                    'O campo :attribute contém linguagem inadequada.'
                );

                return;
            }
        }
    }
}