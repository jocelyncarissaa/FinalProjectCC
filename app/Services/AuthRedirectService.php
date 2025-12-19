<?php

namespace App\Services;

use App\Models\User;

class AuthRedirectService
{
    /**
     * Menentukan rute tujuan berdasarkan role user.
     */
    public function getRedirectPath(User $user): string
    {
        if ($user->role === 'admin') {
            return route('admin.dashboard');
        }

        return route('home');
    }
}