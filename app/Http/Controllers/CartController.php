<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Services\CartPriceService; // Panggil Service

class CartController extends Controller
{
    protected $priceService;

    // Inject Service melalui Constructor agar bisa digunakan di semua method
    public function __construct(CartPriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function index()
    {
        $cartItems = Cart::with('item')->where('user_id', Auth::id())->get();

        // REFACTOR: Gunakan Service untuk menghitung total
        $formattedItems = $cartItems->map(function($cart) {
            return [
                'price' => $cart->item->discount_price ?? $cart->item->price,
                'qty' => $cart->quantity
            ];
        })->toArray();

        $total = $this->priceService->calculateSubtotal($formattedItems);

        return view('user.cart.cart_summary', compact('cartItems', 'total'));
    }

    /**
     * Menambah atau Mengurangi kuantitas produk di keranjang.
     */
    public function add(Request $request)
    {
        // Validasi input
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer',
        ]);

        $item = Item::with('inventory')->findOrFail($request->item_id);
        $existingCart = Cart::where('user_id', Auth::id())
                            ->where('item_id', $request->item_id)
                            ->first();

        if ($existingCart) {
            $newQuantity = $existingCart->quantity + $request->quantity;

            if ($newQuantity <= 0) {
                $existingCart->delete();
                if ($request->ajax()) return response()->json(['status' => 'removed']);
                return redirect()->route('cart')->with('success', 'Item removed from cart.');
            }

            // --- VALIDASI SERVICE (Unit Test Relevan) ---
            // Gunakan isStockSufficient dari service
            if (!$this->priceService->isStockSufficient($newQuantity, $item->inventory->stock)) {
                if ($request->ajax()) return response()->json(['status' => 'error', 'message' => 'Stock insufficient'], 400);
                return redirect()->back()->with('error', 'Stok tidak mencukupi.');
            }

            $existingCart->update(['quantity' => $newQuantity]);
            if($request->notes) {
                $existingCart->update(['notes' => $request->notes]);
            }

            if ($request->ajax()) {
                return response()->json(['status' => 'updated', 'new_qty' => $newQuantity]);
            }
        } else {
            // --- VALIDASI SERVICE UNTUK ITEM BARU ---
            if (!$this->priceService->isStockSufficient($request->quantity, $item->inventory->stock)) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi.');
            }

            Cart::create([
                'user_id' => Auth::id(),
                'item_id' => $request->item_id,
                'quantity' => max(1, $request->quantity),
                'notes' => $request->notes,
            ]);

            if ($request->ajax()) return response()->json(['status' => 'added']);
        }

        return redirect()->route('cart')->with('success', 'Product added to cart!');
    }

    /**
     * Menghapus item secara manual melalui tombol "Remove".
     */
    public function remove($id)
    {
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Item removed.');
    }
}