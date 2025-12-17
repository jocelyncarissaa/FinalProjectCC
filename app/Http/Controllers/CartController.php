<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('item')->where('user_id', Auth::id())->get();
        $total = $cartItems->sum(function($cart) {
            $price = $cart->item->discount_price ?? $cart->item->price;
            return $price * $cart->quantity;
        });

        return view('user.cart.cart_summary', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Cek jika barang sudah ada di keranjang user tersebut
        $existingCart = Cart::where('user_id', Auth::id())
                            ->where('item_id', $request->item_id)
                            ->first();

        if ($existingCart) {
            $existingCart->increment('quantity', $request->quantity);
            if($request->notes) $existingCart->update(['notes' => $request->notes]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'notes' => $request->notes,
            ]);
        }

        return redirect()->route('cart')->with('success', 'Product added to cart!');
    }

    public function remove($id)
    {
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Item removed.');
    }
}