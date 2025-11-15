<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
// LOGINNNN
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'This email is not registered.'])
                ->withInput();
        }

        // Check if password correct
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'Incorrect password.'])
                ->withInput();
        }

        // Try login (success)
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();

        // return redirect()->route('home');
        return redirect()->route('admin.dashboard');

    }
// REGISTERR

    public function showRegister()
    {
        return view('auth.register');
    }


    public function register(Request $request)
    {
        // Validasi input
       $request->validate(
        [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6','regex:/[A-Za-z]/','regex:/[0-9]/','confirmed' ],
        ],
        [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.regex' => 'Password must contain at least one letter and one number.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]
     );

        // Buat user baru
        $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        ]);
        // Auto login setelah register
        Auth::login($user);

        // Redirect ke home
        // return redirect()->route('home');
        // ke dashboard
        return redirect()->route('admin.dashboard');

    }

// LOG OUT
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Balik ke halaman login
        return redirect()->route('login');
    }

// buat profile
    public function profile()
    {
        return view('user.profile', [
            'user' => Auth::user(),
        ]);
    }

}

