<?php

namespace Tests\Unit\Auth;

use PHPUnit\Framework\TestCase;
use App\Rules\PasswordStrength;

class PasswordValidationTest extends TestCase
{
    public function test_password_must_have_letters_and_numbers(): void
    {
        $rule = new PasswordStrength();

        $this->assertFalse($rule->isValid('123456'));
        $this->assertFalse($rule->isValid('abcdef'));
        $this->assertTrue($rule->isValid('pharma123'));
    }
}