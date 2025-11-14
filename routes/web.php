<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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