<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function index()
    {
        $cartItems = Cart::with('item')->where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function($cart) {
            $price = $cart->item->discount_price ?? $cart->item->price;
            return $price * $cart->quantity;
        });

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

        $existingCart = Cart::where('user_id', Auth::id())
                            ->where('item_id', $request->item_id)
                            ->first();

        if ($existingCart) {
            // Hitung kuantitas baru
            $newQuantity = $existingCart->quantity + $request->quantity;

            // Jika kuantitas 0 atau kurang, hapus item
            if ($newQuantity <= 0) {
                $existingCart->delete();
                
                if ($request->ajax()) {
                    return response()->json(['status' => 'removed']);
                }
                return redirect()->route('cart')->with('success', 'Item removed from cart.');
            }

            // Update kuantitas
            $existingCart->update(['quantity' => $newQuantity]);
            
            // Update catatan jika ada kiriman notes baru
            if($request->notes) {
                $existingCart->update(['notes' => $request->notes]);
            }

            // Respons untuk AJAX (Plus-Minus di Cart)
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'updated',
                    'new_qty' => $newQuantity
                ]);
            }
        } else {
            // Jika item belum ada (Tambah dari katalog)
            Cart::create([
                'user_id' => Auth::id(),
                'item_id' => $request->item_id,
                'quantity' => max(1, $request->quantity),
                'notes' => $request->notes,
            ]);

            if ($request->ajax()) {
                return response()->json(['status' => 'added']);
            }
        }

        // Respons default untuk form submit biasa (Halaman Katalog)
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