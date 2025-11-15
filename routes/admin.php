<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\OrderController;

// Semua route admin diproteksi di sini
Route::middleware(['auth', 'admin'])
    ->prefix('admin')      // url: /admin/...
    ->name('admin.')       // nama route: admin.dashboard, admin.items.index, dst
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // CRUD items (obat)
        Route::resource('/items', ItemController::class);

        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

         // Profile page
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

        // Download Report (Excel / PDF)
        Route::get('/report/download/{type}', function ($type) {
            // Dummy response sementara
            return back()->with('status', 'Download ' . strtoupper($type) . ' is not implemented yet.');
        })->name('report.download');
    });





