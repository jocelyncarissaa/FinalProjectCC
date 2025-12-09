<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ShipmentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Definisikan route untuk aplikasi Anda.
|
*/


// =========================================================================
// == KELOMPOK 1: ROUTES GUEST / PUBLIC (TANPA PERLU LOGIN)
// =========================================================================

// 1. LANDING PAGE (Welcome/Home Public)
// Ini akan merender home.blade.php (asumsi menggunakan header biasa)
Route::get('/', [UserController::class, 'index'])->name('welcome'); 

// 2. PUBLIC PAGES (About Us, Contact Us)
// Tidak ada middleware 'auth', bisa diakses siapa saja
Route::get('/about-us', function () {
    return view('user.pages.about_us'); 
})->name('about');

Route::get('/contact-us', function () {
    return view('user.pages.contact'); 
})->name('contact');

// 3. AUTHENTICATION GUEST ROUTES (Login/Register Forms)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


// =========================================================================
// == KELOMPOK 2: ROUTES PROTECTED (SETELAH LOGIN)
// =========================================================================
Route::middleware('auth')->group(function () {

    // 1. HOME PAGE AUTHENTICATED
    // Ini akan merender user/home_auth.blade.php (asumsi menggunakan header_auth)
    Route::get('/home', function () {
        return view('user.home_auth'); 
    })->name('home'); // Nama 'home' PENTING untuk redirect setelah login

    // 2. LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // 3. PRODUCTS INDEX & DETAIL (Hanya bisa diakses setelah login)
    Route::get('/products', function () {
        return view('user.products.product_list'); 
    })->name('products');

    Route::get('/product-detail', function () {
        return view('user.products.product_detail');
    })->name('product.detail');
    
    // 4. CART & PROFILE
    Route::get('/cart', function () {
        return view('user.cart.cart'); 
    })->name('cart');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');


    // =========================================================================
    // == KELOMPOK 3: ROUTES ADMIN (MASUK DI BAWAH MIDDELWARE 'AUTH')
    // =========================================================================
    // Anda bisa menambahkan middleware 'role:admin' di sini jika sudah ada
    Route::prefix('admin')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Report
        Route::get('/report/download/{type}', function ($type) {
            // TO DO: implement real export (Excel/PDF)
            return back()->with('status', 'Download ' . strtoupper($type) . ' is not implemented yet.');
        })->name('admin.report.download');

        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.update_status');

        // Items
        Route::get('/items', [ItemController::class, 'index'])->name('admin.items.index');
        Route::get('/items/create',    [ItemController::class, 'create'])->name('admin.items.create');
        Route::post('/items',          [ItemController::class, 'store'])->name('admin.items.store');
        Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('admin.items.edit');
        Route::put('/items/{item}', [ItemController::class, 'update'])->name('admin.items.update');
        Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('admin.items.destroy');

        // Shipment Report
        Route::get('/shipments', [ShipmentController::class, 'index'])->name('admin.shipments.index');
        Route::get('/shipments/create', [ShipmentController::class, 'create'])->name('admin.shipments.create');
        Route::post('/shipments', [ShipmentController::class, 'store'])->name('admin.shipments.store');
        Route::get('/shipments/{shipment}', [ShipmentController::class, 'show'])->name('admin.shipments.show');
    });

});