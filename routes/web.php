<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Definisikan route untuk aplikasi Anda.
|
*/

// Route utama Laravel (default)
// Route::get('/', function () {
//     return view('welcome');
// });

// Route untuk Halaman Beranda Customer
// Menggunakan UserController@index untuk melayani /home
Route::get('/', [UserController::class, 'index'])->name('home');

// == Login dan register =============
Route::get('/login', function () {return view('auth.login'); })->name('login');
Route::get('/register', function () {return view('auth.register');})->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
// Logout
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// == Dashboard (butuh login)==================
Route::middleware('auth')->group(function () {
    // Home setelah login
    // Route::get('/', [UserController::class, 'index'])->name('home');

    // Admin dashboard
    Route::get('/admin/dashboard', function () {
        // nanti bisa diganti Controller kalau mau dynamic
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Profile page
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // untuk download report
    Route::get('/admin/report/download/{type}', function ($type) {
    // TO DO: implement real export (Excel/PDF)
    return back()->with('status', 'Download ' . strtoupper($type) . ' is not implemented yet.');
    })->name('admin.report.download')->middleware('auth');

});

