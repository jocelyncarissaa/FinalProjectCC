<?php

// app/Http/Controllers/CheckoutController.php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Menyimpan order baru ke database.
     
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang Anda kosong!');
        }

        try {
            DB::beginTransaction();

            // 1. Validasi Stok 
            foreach ($cart as $id => $details) {
                $inventory = Inventory::find($id); 
                if (!$inventory || $inventory->stock < $details['quantity']) {
                    throw new \Exception('Stok untuk ' . $details['name'] . ' tidak mencukupi.');
                }
            }

            // 2. Buat Order 
            $order = Order::create([
                'user_id' => Auth::id(), 
                'total_price' => $this->calculateTotalPrice($cart), 
                'status' => 'pending', 
                'shipping_address' => $request->input('address') 
            ]);

            // 3. Buat Order Details & Kurangi Stok
            foreach ($cart as $id => $details) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'item_id' => $id,
                    'quantity' => $details['quantity'],
                    'price_per_unit' => $details['price']
                ]);

                $inventory = Inventory::find($id);
                $inventory->decrement('stock', $details['quantity']);
            }

            // 4. Panggil Event Email 
            // blablabla

            DB::commit();
            session()->forget('cart');

            // Redirect ke success page
            return redirect()->route('order.history')->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    private function calculateTotalPrice($cart)
    {
        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }
        return $total;
    }
}