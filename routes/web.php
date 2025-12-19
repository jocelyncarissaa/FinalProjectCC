<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderProcessController;


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
    Route::get('/auth/about-us', function () {
        return view('user.pages.about_us');
    })->name('about.auth');

    Route::get('/auth/contact-us', function () {
        return view('user.pages.contact');
    })->name('contact.auth');

    // 4. PRODUCTS & DETAIL
    Route::get('/products', [ItemController::class, 'index'])->name('products');

    // Route::get('/product-detail/{id}', function ($id) {
    //     // TODO: Ganti ini dengan ItemController@show untuk menampilkan detail
    //     return view('user.products.product_detail');
    // })->name('product.detail');

    // 5. FITUR CART (KERANJANG)
    // Menampilkan halaman ringkasan keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart');

    Route::get('/checkout', function () {
        return "Halaman Checkout Segera Hadir";
    })->name('checkout');

    // Proses menambah barang ke database (Dipanggil oleh form modal di katalog)
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

    // Tambahan: Hapus barang dari keranjang
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/orders/execute', [OrderProcessController::class, 'store'])->name('orders.execute');
    Route::get('/orders/success/{id}', [OrderProcessController::class, 'success'])->name('orders.success');

    // 6. PROFILE & ORDERS
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/profile/order/{id}', [UserController::class, 'showOrderDetail'])->name('profile.order.detail');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

  
    // KELOMPOK 3: ROUTES ADMIN

    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/report/download/{type}', function ($type) {
            return back()->with('status', 'Download ' . strtoupper($type) . ' is not implemented yet.');
        })->name('admin.report.download');

        // Admin Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::post('/orders/{order}', [OrderController::class, 'updateStatus'])->name('admin.orders.update_status');

        // Admin Items (CRUD)
        Route::get('/items', [AdminItemController::class, 'index'])->name('admin.items.index');
        Route::get('/items/create', [AdminItemController::class, 'create'])->name('admin.items.create');
        Route::post('/items', [AdminItemController::class, 'store'])->name('admin.items.store');
        Route::get('/items/{item}/edit', [AdminItemController::class, 'edit'])->name('admin.items.edit');
        Route::put('/items/{item}', [AdminItemController::class, 'update'])->name('admin.items.update');
        Route::delete('/items/{item}', [AdminItemController::class, 'destroy'])->name('admin.items.destroy');

        // Shipment Report
        Route::get('/shipments', [ShipmentController::class, 'index'])->name('admin.shipments.index');
        Route::get('/shipments/create', [ShipmentController::class, 'create'])->name('admin.shipments.create');
        Route::post('/shipments', [ShipmentController::class, 'store'])->name('admin.shipments.store');
        Route::get('/shipments/{shipment}', [ShipmentController::class, 'show'])->name('admin.shipments.show');

    });

});

if (app()->environment(['local', 'testing'])) {
    Route::get('/bdd/products', [ItemController::class, 'index'])->name('bdd.products');
}


