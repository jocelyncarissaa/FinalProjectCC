<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Services\AuthRedirectService;
use App\Rules\PasswordStrength;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'This email is not registered.'])
                ->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'Incorrect password.'])
                ->withInput();
        }

        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();

        // Memanggil Service Asli
        $redirectService = new AuthRedirectService();
        return redirect($redirectService->getRedirectPath($user));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
       $request->validate(
        [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required', 
                'string', 
                'min:6', 
                'confirmed', 
                new PasswordStrength() 
            ],
        ],
        [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]
     );

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        Auth::login($user);

        // Memanggil Service Asli
        $redirectService = new AuthRedirectService();
        return redirect($redirectService->getRedirectPath($user));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function profile()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->get();
        return view('user.profile.profile', compact('user', 'orders'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}