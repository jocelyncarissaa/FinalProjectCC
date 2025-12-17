<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user.home'); 
    }

    public function showOrderDetail($id)
    {
        // Mencari order dengan relasi items dan produknya
        $order = Order::with(['items.item', 'user'])->findOrFail($id);

        // Proteksi: User hanya bisa melihat pesanan miliknya
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.orders.order_details', compact('order'));
    }
}