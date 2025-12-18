<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;

class PasswordValidationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        // Setup minimal untuk Laravel Facade di Unit Test
        $app = new Container();
        $app->bind('validator', function () {
            return new \Illuminate\Validation\Factory(new \Illuminate\Translation\Translator(
                new \Illuminate\Translation\ArrayLoader(), 'en'
            ));
        });
        Facade::setFacadeApplication($app);
    }

    /**
     * Mengetes aturan regex password: harus ada huruf dan angka.
     */
    public function test_password_must_contain_letters_and_numbers(): void
    {
        $rules = ['password' => ['required', 'string', 'min:6', 'regex:/[A-Za-z]/', 'regex:/[0-9]/']];

        // Skenario 1: Hanya angka (Harus Fail)
        $validator1 = \Illuminate\Support\Facades\Validator::make(['password' => '123456'], $rules);
        $this->assertTrue($validator1->fails());

        // Skenario 2: Hanya huruf (Harus Fail)
        $validator2 = \Illuminate\Support\Facades\Validator::make(['password' => 'abcdef'], $rules);
        $this->assertTrue($validator2->fails());

        // Skenario 3: Huruf dan angka (Harus Pass)
        $validator3 = \Illuminate\Support\Facades\Validator::make(['password' => 'pharma123'], $rules);
        $this->assertFalse($validator3->fails());
    }
}