<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\CartPriceService; // Import Service Harga & Stok
use App\Services\CheckoutService;  // Import Service Kelayakan Checkout

class CheckoutController extends Controller
{
    protected $priceService;
    protected $checkoutService;


    public function __construct(CartPriceService $priceService, CheckoutService $checkoutService)
    {
        $this->priceService = $priceService;
        $this->checkoutService = $checkoutService;
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        $address = $request->input('address');

        // 1. Validasi Kelayakan (Menggunakan CheckoutService)
        // Mengecek apakah keranjang kosong atau alamat belum diisi
        if (!$this->checkoutService->isEligible($cart, $address)) {
            return redirect()->route('cart.index')->with('error', 'Lengkapi keranjang dan alamat pengiriman Anda!');
        }

        try {
            DB::beginTransaction();

            foreach ($cart as $id => $details) {
                $inventory = Inventory::where('item_id', $id)->first();
               
                if (!$inventory || !$this->priceService->isStockSufficient($details['quantity'], $inventory->stock)) {
                    throw new \Exception('Stok untuk ' . $details['name'] . ' tidak mencukupi.');
                }
            }

            $formattedItems = collect($cart)->map(fn($item) => [
                'price' => $item['price'],
                'qty' => $item['quantity']
            ])->toArray();
            
            $totalPrice = $this->priceService->calculateSubtotal($formattedItems);

            // 4. Buat Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'shipping_address' => $address
            ]);

            // 5. Simpan Detail & Kurangi Stok
            foreach ($cart as $id => $details) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'item_id' => $id,
                    'quantity' => $details['quantity'],
                    'price_per_unit' => $details['price']
                ]);

                // Update stok di DB
                Inventory::where('item_id', $id)->decrement('stock', $details['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('order.history')->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }
}