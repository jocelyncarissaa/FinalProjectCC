<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ItemController;



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
Route::get('/', [UserController::class, 'index'])->name('home'); //buat client/user

// == Login dan register =============
// Route::get('/login', function () {return view('auth.login'); })->name('login');
// Route::get('/register', function () {return view('auth.register');})->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
// Logout
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// == Dashboard Admin(butuh login)==================
Route::middleware('auth')->group(function () {

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

    // List all orders
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');

    // View single order detail
    Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');

    // Optional: Update order status
    Route::post('/admin/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.update_status');

    Route::get('/admin/items', [ItemController::class, 'index'])->name('admin.items.index');

    Route::get('/items/create',    [ItemController::class, 'create'])->name('admin.items.create');
     Route::post('/items',          [ItemController::class, 'store'])->name('admin.items.store');

    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('admin.items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('admin.items.update');

    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('admin.items.destroy');

});

