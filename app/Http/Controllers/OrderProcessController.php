<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CartPriceService; // Import Service Harga & Stok
use App\Services\CheckoutService;  // Import Service Kelayakan Checkout

class OrderProcessController extends Controller
{
    protected $priceService;
    protected $checkoutService;

    // Inject Service melalui Constructor
    public function __construct(CartPriceService $priceService, CheckoutService $checkoutService)
    {
        $this->priceService = $priceService;
        $this->checkoutService = $checkoutService;
    }

    public function store()
    {
        $user = Auth::user();
        $cartItems = Cart::with('item.inventory')->where('user_id', $user->id)->get();

        // 1. Validasi Kelayakan menggunakan Service (Keranjang & Alamat)
        if (!$this->checkoutService->isEligible($cartItems->toArray(), $user->address)) {
            return redirect()->route('cart')->with('error', 'Lengkapi keranjang dan alamat Anda.');
        }

        return DB::transaction(function () use ($cartItems, $user) {
            
            // 2. Hitung Total Menggunakan Service
            $formattedItems = $cartItems->map(fn($c) => [
                'price' => $c->item->discount_price ?? $c->item->price,
                'qty' => $c->quantity
            ])->toArray();
            
            $totalAmount = $this->priceService->calculateSubtotal($formattedItems);

            // 3. Buat Header Order (Ganti total_price ke total_amount sesuai DB kamu)
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'pending', 
                'shipping_address' => $user->address ?? 'Alamat Belum Diatur',
            ]);

            // 4. Simpan item & potong stok
            foreach ($cartItems as $cart) {
                
                // VALIDASI STOK: Panggil logic yang sudah lolos Unit Test
                // Jika ingin membiarkan stok bisa minus (untuk demo bug), komentari bagian IF di bawah ini.
                if (!$this->priceService->isStockSufficient($cart->quantity, $cart->item->inventory->stock)) {
                    throw new \Exception("Stok untuk {$cart->item->name} tidak mencukupi.");
                }

                OrderDetail::create([
                    'order_id' => $order->id,
                    'item_id' => $cart->item_id,
                    'quantity' => $cart->quantity,
                    'price_per_unit' => $cart->item->discount_price ?? $cart->item->price
                ]);
                
                // Kurangi stok di database
                Inventory::where('item_id', $cart->item_id)->decrement('stock', $cart->quantity);
            }

            // 5. Hapus keranjang
            Cart::where('user_id', $user->id)->delete();

            return redirect()->route('orders.success', $order->id);
        });
    }

    public function success($id)
    {
        $order = Order::with(['items.item', 'user'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.orders.success_payment', compact('order'));
    }
}