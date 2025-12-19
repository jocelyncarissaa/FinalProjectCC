<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Services\AuthRedirectService;

class AuthRedirectTest extends TestCase
{
    public function test_it_returns_admin_dashboard_url_for_admin_role(): void
    {
        $user = new User(['role' => 'admin']);
        $service = new AuthRedirectService();

        $path = $service->getRedirectPath($user);

        $this->assertEquals(route('admin.dashboard'), $path);
    }

    public function test_it_returns_home_url_for_regular_user_role(): void
    {
        $user = new User(['role' => 'user']);
        $service = new AuthRedirectService();

        $path = $service->getRedirectPath($user);

        $this->assertEquals(route('home'), $path);
    }
}