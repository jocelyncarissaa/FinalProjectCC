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

    /**
     * Menampilkan profil user beserta riwayat pesanan yang diurutkan dari yang terbaru.
     */
    public function profile()
    {
        $user = Auth::user();
        
        // Mengurutkan berdasarkan ID terbaru agar Order #8 di atas #1
        $orders = Order::where('user_id', $user->id)
                       ->orderBy('id', 'desc') 
                       ->get();

        return view('user.profile', compact('user', 'orders'));
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function showOrderDetail($id)
    {
        // Eager load 'items.item' agar gambar dan detail obat muncul
        $order = Order::with(['items.item', 'user'])->findOrFail($id);

        // Security check
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user.orders.order_details', compact('order'));
    }
}