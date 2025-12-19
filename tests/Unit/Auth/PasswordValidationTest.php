<?php

namespace Tests\Unit\Auth;

use PHPUnit\Framework\TestCase;
use App\Rules\PasswordStrength;

class PasswordValidationTest extends TestCase
{
    public function test_password_strength_validation_logic(): void
    {
        $rule = new PasswordStrength();
        
        // 1. Gagal karena hanya angka
        $this->assertFalse($rule->isValid('123456'));

        // 2. Gagal karena hanya huruf
        $this->assertFalse($rule->isValid('abcdef'));

        // 3. Gagal karena kurang dari 6 karakter (Boundary Test)
        $this->assertFalse($rule->isValid('a1b2'));

        // 4. Gagal karena kosong
        $this->assertFalse($rule->isValid(''));
        
        // 5. Berhasil karena memenuhi semua syarat (huruf + angka + >= 6 char)
        $this->assertTrue($rule->isValid('pharma123'));
        $this->assertTrue($rule->isValid('123abc456'));
    }
}