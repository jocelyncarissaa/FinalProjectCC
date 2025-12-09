<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ShipmentController;


// == KELOMPOK 1: ROUTES GUEST / PUBLIC (TANPA PERLU LOGIN) =================

Route::get('/', [UserController::class, 'index'])->name('welcome'); 

// PUBLIC PAGES
Route::get('/about-us', function () {
    return view('user.pages.about_us'); 
})->name('about');

Route::get('/contact-us', function () {
    return view('user.pages.contact'); 
})->name('contact');

// AUTHENTICATION GUEST ROUTES
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


// == KELOMPOK 2: ROUTES PROTECTED (SETELAH LOGIN) ==========================
Route::middleware('auth')->group(function () {

    // HOME PAGE AUTHENTICATED
    Route::get('/home', function () {
        return view('user.home_auth'); 
    })->name('home');

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // PAGES TERPROTEKSI (Dipanggil dari header_auth)
    // Walaupun memanggil view yang sama, route-nya berbeda
    Route::get('/auth/about-us', function () {
        return view('user.pages.about_us'); 
    })->name('about.auth');

    Route::get('/auth/contact-us', function () {
        return view('user.pages.contact'); 
    })->name('contact.auth');

    // PRODUCTS, CART, PROFILE, etc.
    Route::get('/products', function () {
        return view('user.products.product_list'); 
    })->name('products');

    Route::get('/product-detail', function () {
        return view('user.products.product_detail');
    })->name('product.detail');
    
    Route::get('/cart', function () {
        return view('user.cart.cart'); 
    })->name('cart');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');


    // == ROUTES ADMIN ========================================================
    Route::prefix('admin')->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/report/download/{type}', function ($type) {
            return back()->with('status', 'Download ' . strtoupper($type) . ' is not implemented yet.');
        })->name('admin.report.download');

        // Orders, Items, Shipments Routes... (Dipersingkat)
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/items', [ItemController::class, 'index'])->name('admin.items.index');
        Route::get('/shipments', [ShipmentController::class, 'index'])->name('admin.shipments.index');
        // ... (Route lainnya)
    });

});