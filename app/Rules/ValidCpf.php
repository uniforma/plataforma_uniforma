<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCpf implements ValidationRule
{
    public static function digits(?string $value): string
    {
        return preg_replace('/\D/', '', $value ?? '') ?? '';
    }

    public static function isValid(?string $value): bool
    {
        $digits = self::digits($value);

        if (strlen($digits) !== 11 || preg_match('/^(\d)\1{10}$/', $digits)) {
            return false;
        }

        for ($length = 9; $length < 11; $length++) {
            $sum = 0;
            for ($position = 0; $position < $length; $position++) {
                $sum += (int) $digits[$position] * ($length + 1 - $position);
            }
            $remainder = ($sum * 10) % 11;
            $expected = $remainder === 10 ? 0 : $remainder;
            if ((int) $digits[$length] !== $expected) {
                return false;
            }
        }

        return true;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! self::isValid($value)) {
            $fail('Informe um CPF válido.');
        }
    }
}
