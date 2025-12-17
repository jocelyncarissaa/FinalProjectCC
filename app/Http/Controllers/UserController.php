<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Menampilkan halaman beranda customer.
     */
    public function index()
    {
        // View yang dikembalikan: resources/views/user/home.blade.php
        return view('user.home'); 
    }

    public function showOrderDetail($id)
    {
        // 1. Find the order by ID, or fail with 404 if not found
        // We also eager load 'items' (or whatever your relationship is named)
        $order = Order::with('items')->findOrFail($id);

        // 2. SECURITY CHECK: Ensure the logged-in user actually owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 3. Return the view with the order data
        return view('user.orders.order_details', compact('order'));
    }
}