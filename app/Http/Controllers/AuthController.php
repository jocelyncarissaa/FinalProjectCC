<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;

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

        // Login sukses
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();

        //Redirect berdasarkan role nya
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        // user biasa
        return redirect()->route('home');

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
        'role'     => 'user',    //default role = user
        ]);

        // Auto login setelah register
        Auth::login($user);

       // Redirect user baru → ke /home
        return redirect()->route('home');

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
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mengambil riwayat pesanan (orders) milik user yang login
        $orders = Order::where('user_id', $user->id)->latest()->get();

        return view('user.profile.profile', compact('user', 'orders'));
    }

    public function updateProfile(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15', // Sesuaikan panjang max
            'address' => 'nullable|string|max:500',
        ]);

        // 2. Ambil User & Update
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            // Email sengaja tidak di-update di sini untuk keamanan (biasanya butuh verifikasi ulang)
        ]);

        // 3. Redirect kembali dengan pesan sukses
        return back()->with('success', 'Profile updated successfully!');
    }
}

