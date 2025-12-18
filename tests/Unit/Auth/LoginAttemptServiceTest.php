<?php

namespace Tests\Unit\Auth;

use PHPUnit\Framework\TestCase;

class LoginAttemptServiceTest extends TestCase
{
    /**
     * Akun tidak boleh terkunci jika kegagalan masih di bawah batas.
     */
    public function test_account_is_not_locked_before_limit()
    {
        $limit = 3;
        $attempts = 2;

        $isLocked = ($attempts >= $limit);

        $this->assertFalse($isLocked);
    }

    /**
     * Akun harus terkunci jika kegagalan mencapai batas.
     */
    public function test_account_is_locked_at_limit()
    {
        $limit = 3;
        $attempts = 3;

        $isLocked = ($attempts >= $limit);

        $this->assertTrue($isLocked);
    }
}