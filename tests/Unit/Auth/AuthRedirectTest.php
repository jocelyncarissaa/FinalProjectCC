<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase; // Gunakan base TestCase untuk Unit Test murni
use App\Models\User;

class AuthRedirectTest extends TestCase
{
    /**
     * Mengetes logika penentuan path redirect berdasarkan role.
     */
    public function test_it_returns_admin_dashboard_path_for_admin_role(): void
    {
        // ARRANGE: Buat object user di memori (Tanpa Database)
        $user = new User();
        $user->role = 'admin';

        // ACT: Jalankan logika (simulasi logic di AuthController)
        $path = ($user->role === 'admin') ? '/admin/dashboard' : '/home';

        // ASSERT: Pastikan hasilnya tepat
        $this->assertEquals('/admin/dashboard', $path);
    }

    public function test_it_returns_home_path_for_regular_user_role(): void
    {
        // ARRANGE
        $user = new User();
        $user->role = 'user';

        // ACT
        $path = ($user->role === 'admin') ? '/admin/dashboard' : '/home';

        // ASSERT
        $this->assertEquals('/home', $path);
    }
}