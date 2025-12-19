<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CartPriceService;     
use App\Services\CheckoutService;       
use App\Services\OrderStatusService;    

class OrderProcessController extends Controller
{
    protected $priceService;
    protected $checkoutService;
    protected $statusService;

    /**
     * Dependency Injection melalui Constructor agar semua Service
     * bisa digunakan di dalam Controller ini.
     */
    public function __construct(
        CartPriceService $priceService, 
        CheckoutService $checkoutService,
        OrderStatusService $statusService
    ) {
        $this->priceService = $priceService;
        $this->checkoutService = $checkoutService;
        $this->statusService = $statusService;
    }

    /**
     * Memproses pesanan dari keranjang ke database.
     */
    public function store()
    {
        $user = Auth::user();
        // Load keranjang beserta data item dan inventory-nya
        $cartItems = Cart::with('item.inventory')->where('user_id', $user->id)->get();

        // 1. Validasi Kelayakan (Menggunakan CheckoutService)
        // Mengecek apakah keranjang kosong atau alamat belum diatur
        if (!$this->checkoutService->isEligible($cartItems->toArray(), $user->address)) {
            return redirect()->route('cart')->with('error', 'Lengkapi keranjang dan alamat Anda di profil sebelum checkout.');
        }

        return DB::transaction(function () use ($cartItems, $user) {
            
            // 2. Siapkan data item untuk dihitung oleh Service
            $formattedItems = $cartItems->map(fn($c) => [
                'price' => $c->item->discount_price ?? $c->item->price,
                'qty' => $c->quantity
            ])->toArray();
            
            // Hitung total menggunakan CartPriceService (Logic yang di-Unit Test)
            $totalAmount = $this->priceService->calculateSubtotal($formattedItems);

            // 3. Buat Header Order 
            // Menggunakan 'total_amount' sesuai struktur kolom database Anda
            $order = Order::create([
                'user_id'      => $user->id,
                'total_amount' => $totalAmount,
                'status'       => 'pending', // Status awal yang divalidasi OrderStatusService
                'shipping_address' => $user->address,
            ]);

            // 4. Simpan Detail Item & Potong Stok
            foreach ($cartItems as $cart) {
                
                /**
                 * VALIDASI STOK (Guard Clause)
                 * Memanggil isStockSufficient dari CartPriceService.
                 * Jika ingin mendemonstrasikan BUG STOK MINUS untuk laporan, 
                 * Anda bisa memberikan komentar (disable) pada blok IF di bawah ini.
                 */
                if (!$this->priceService->isStockSufficient($cart->quantity, $cart->item->inventory->stock)) {
                    throw new \Exception("Stok untuk produk {$cart->item->name} tidak mencukupi.");
                }

                // Simpan detail pesanan
                OrderDetail::create([
                    'order_id'       => $order->id,
                    'item_id'        => $cart->item_id,
                    'quantity'       => $cart->quantity,
                    'price_per_unit' => $cart->item->discount_price ?? $cart->item->price
                ]);
                
                // Kurangi stok di tabel inventory
                Inventory::where('item_id', $cart->item_id)->decrement('stock', $cart->quantity);
            }

            // 5. Hapus data keranjang setelah pesanan berhasil dibuat
            Cart::where('user_id', $user->id)->delete();

            // Redirect ke halaman sukses
            return redirect()->route('orders.success', $order->id);
        });
    }

    /**
     * Menampilkan halaman sukses setelah pembayaran/checkout.
     */
    public function success($id)
    {
        $order = Order::with(['items.item', 'user'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('user.orders.success_payment', compact('order'));
    }
}