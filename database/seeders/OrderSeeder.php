<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Item;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'customer@gmail.com')->first();
        $items = Item::all();

        if(!$user || $items->isEmpty()) return;

        // Buat 5 Dummy Order
        for ($i = 0; $i < 5; $i++) {
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => 0, // Nanti dihitung
                'status' => ['pending', 'paid', 'shipped'][rand(0, 2)],
                'shipping_address' => 'Jl. Dummy No. ' . ($i + 1) . ', Jakarta',
            ]);

            $total = 0;
            // Masukkan 1-3 barang acak ke order ini
            $randomItems = $items->random(rand(1, 3));

            foreach ($randomItems as $item) {
                $qty = rand(1, 3);
                OrderDetail::create([
                    'order_id' => $order->id,
                    'item_id' => $item->id,
                    'quantity' => $qty,
                    'price_per_unit' => $item->price
                ]);
                $total += ($item->price * $qty);
            }

            // Update total harga order
            $order->update(['total_amount' => $total]);
        }
    }
}