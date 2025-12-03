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

// Route utama Laravel (default)
// Route::get('/', function () {
//     return view('welcome');
// });

// == ROUTES PUBLIC / GUEST (BEFORE LOGIN) ==============================

// 1. LANDING PAGE (Guest View)
Route::get('/', [UserController::class, 'index'])->name('welcome'); // Merender welcome.blade.php

// 2. PUBLIC PAGES (About Us, Contact Us)
Route::get('/about-us', function () {
    // Merender user/pages/about_us.blade.php
    return view('user.pages.about_us'); 
})->name('about');

Route::get('/contact-us', function () {
    // Merender user/pages/contact_us.blade.php
    return view('user.pages.contact'); 
})->name('contact');

// == LOGIN DAN REGISTER =============================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
// Logout
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// == ROUTES PROTECTED (AFTER LOGIN) =================================

// Semua route di bawah ini memerlukan pengguna yang sudah terautentikasi (auth)
Route::middleware('auth')->group(function () {

    // 1. HOME PAGE AUTHENTICATED (Menggantikan /home untuk user yang sudah login)
    // Ini akan merender user/pages/home_auth.blade.php
    Route::get('/home', function () {
        return view('user.home_auth'); 
    })->name('home'); // PENTING: Menggunakan nama 'home' agar menjadi redirect setelah login

    // 2. PRODUCTS INDEX (Ditambahkan ke header_auth)
    Route::get('/products', function () {
        // Asumsi ini merender user/products/product_list.blade.php
        return view('user.products.product_list'); 
    })->name('products');

    // 3. PRODUCT DETAIL (Ditautkan dari card di home_auth)
    Route::get('/product-detail', function () {
        // Merender user/products/product_detail.blade.php
        return view('user.products.product_detail');
    })->name('product.detail');
    
    // 4. CART
    Route::get('/cart', function () {
        return view('user.cart.cart'); // Asumsi view cart
    })->name('cart');

    // 5. Profile page
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    // == Dashboard Admin(butuh login)==================
    // Route::get('/admin/dashboard', function () {
    //     // nanti bisa diganti Controller kalau mau dynamic
    //     return view('admin.dashboard');
    // })->name('admin.dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

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

    // == Items ===
    Route::get('/admin/items', [ItemController::class, 'index'])->name('admin.items.index');

    Route::get('/items/create',    [ItemController::class, 'create'])->name('admin.items.create');
    Route::post('/items',          [ItemController::class, 'store'])->name('admin.items.store');

    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('admin.items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('admin.items.update');

    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('admin.items.destroy');

    // Shipment Report
   Route::get('/admin/shipments', [ShipmentController::class, 'index'])->name('admin.shipments.index');
   Route::get('/admin/shipments/create', [ShipmentController::class, 'create'])->name('admin.shipments.create');
   Route::post('/admin/shipments', [ShipmentController::class, 'store'])->name('admin.shipments.store');
   Route::get('/admin/shipments/{shipment}', [ShipmentController::class, 'show'])->name('admin.shipments.show');
});