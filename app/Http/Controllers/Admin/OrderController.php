<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan list order
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();
        if ($request->has('status') && $request->status != '' && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10);
        $orders->appends($request->all());
        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail order (Verifikasi item & stok)
    public function show($id)
    {
        // Load order beserta user dan items (order details)
        $order = Order::with(['user', 'orderDetails.item'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully!');
    }
}