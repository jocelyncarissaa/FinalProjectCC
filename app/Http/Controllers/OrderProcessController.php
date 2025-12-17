<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderProcessController extends Controller
{
    public function store()
    {
        $user = Auth::user();
        $cartItems = Cart::with('item')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Keranjang kosong.');
        }

        return DB::transaction(function () use ($cartItems, $user) {
            // 1. Buat Header Order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $cartItems->sum(fn($c) => ($c->item->discount_price ?? $c->item->price) * $c->quantity),
                'status' => 'pending', 
                'shipping_address' => $user->address ?? 'Alamat Belum Diatur',
            ]);

            // 2. Simpan tiap item ke OrderDetails & Kurangi Stok
            foreach ($cartItems as $cart) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'item_id' => $cart->item_id,
                    'quantity' => $cart->quantity,
                    'price_per_unit' => $cart->item->discount_price ?? $cart->item->price
                ]);
                
                Inventory::where('item_id', $cart->item_id)->decrement('stock', $cart->quantity);
            }

            // 3. Hapus data di keranjang
            Cart::where('user_id', $user->id)->delete();

            return redirect()->route('orders.success', $order->id);
        });
    }

    public function success($id)
    {
        // Memanggil relasi 'details' yang sudah kita buat di model Order
        $order = Order::with(['details.item', 'user']) // Gunakan array untuk memanggil banyak relasi
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.orders.success_payment', compact('order'));
    }
}