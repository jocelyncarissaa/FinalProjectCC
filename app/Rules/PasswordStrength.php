<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordStrength implements ValidationRule
{
    /**
     * Menjalankan aturan validasi untuk Laravel validator.
     * Digunakan secara otomatis oleh Controller.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValid($value)) {
            $fail('The :attribute must be at least 6 characters and contain both letters and numbers.');
        }
    }


    public function isValid(string $value): bool
    {
        $hasLetter = preg_match('/[A-Za-z]/', $value);
        $hasNumber = preg_match('/[0-9]/', $value);
        $isLongEnough = strlen($value) >= 6;

        // Mengembalikan TRUE hanya jika semua syarat terpenuhi
        return $hasLetter && $hasNumber && $isLongEnough;
    }
}