<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordStrength implements ValidationRule
{
    /**
     * Menjalankan aturan validasi untuk Laravel validator.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValid($value)) {
            $fail('Password must contain at least one letter and one number.');
        }
    }

    /**
     * Logika murni untuk Unit Test agar bisa dites tanpa sistem validator.
     */
    public function isValid(string $value): bool
    {
        return preg_match('/[A-Za-z]/', $value) && preg_match('/[0-9]/', $value);
    }
}