<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
// Pastikan ItemController ada di sini
use App\Http\Controllers\ItemController; 
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ShipmentController;


// =========================================================================
// == KELOMPOK 1: ROUTES GUEST / PUBLIC (TANPA PERLU LOGIN)
// =========================================================================

// 1. LANDING PAGE (Welcome/Home Public)
Route::get('/', [UserController::class, 'index'])->name('welcome'); 

// 2. PUBLIC PAGES (About Us, Contact Us)
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
    Route::get('/home', function () {
        return view('user.home_auth'); 
    })->name('home');

    // 2. LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // 3. PAGES TERPROTEKSI (Menggunakan header_auth)
    // Tautan di header_auth akan diarahkan ke route ini
    Route::get('/auth/about-us', function () {
        return view('user.pages.about_us'); 
    })->name('about.auth');

    Route::get('/auth/contact-us', function () {
        return view('user.pages.contact'); 
    })->name('contact.auth');

    // 4. PRODUCTS, CART, PROFILE, etc.
    // MODIFIKASI: Menggunakan ItemController untuk daftar produk
    Route::get('/products', [ItemController::class, 'index'])->name('products');

    Route::get('/product-detail/{id}', function ($id) {
        // TODO: Ganti ini dengan ItemController@show untuk menampilkan detail
        return view('user.products.product_detail');
    })->name('product.detail');
    
    Route::get('/cart', function () {
        return view('user.cart.cart'); 
    })->name('cart');

    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');


    // =========================================================================
    // == KELOMPOK 3: ROUTES ADMIN
    // =========================================================================
    Route::prefix('admin')->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::get('/report/download/{type}', function ($type) {
            return back()->with('status', 'Download ' . strtoupper($type) . ' is not implemented yet.');
        })->name('admin.report.download');

        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::post('/orders/{order}', [OrderController::class, 'updateStatus'])->name('admin.orders.update_status');
        
        // Items (CRUD)
        // Perhatian: Rute Admin Item harus berbeda dengan rute client Item
        Route::get('/items', [ItemController::class, 'indexAdmin'])->name('admin.items.index'); 
        // Anda mungkin perlu membuat fungsi indexAdmin() di ItemController untuk tampilan admin

        // Route CRUD Item lainnya...
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