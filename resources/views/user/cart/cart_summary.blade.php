@extends('user.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-8">Your Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <div class="bg-blue-50 p-10 text-center rounded-xl">
            <p class="text-xl text-gray-600">Your cart is empty.</p>
            <a href="{{ route('products') }}" class="mt-4 inline-block bg-[#1364FF] text-white px-6 py-2 rounded-lg">Go Shopping</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                @foreach($cartItems as $cart)
                    <div class="flex items-center justify-between border-b pb-4 mb-4">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset($cart->item->image_path) }}" class="w-20 h-20 object-contain bg-gray-100 rounded">
                            <div>
                                <h3 class="font-bold">{{ $cart->item->name }}</h3>
                                <p class="text-sm text-gray-500">Qty: {{ $cart->quantity }}</p>
                                @if($cart->notes) <p class="text-xs italic">Note: {{ $cart->notes }}</p> @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-[#1364FF]">Rp{{ number_format(($cart->item->discount_price ?? $cart->item->price) * $cart->quantity, 0, ',', '.') }}</p>
                            <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 text-sm hover:underline">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-gray-50 p-6 rounded-xl h-fit">
                <h3 class="text-xl font-bold mb-4">Order Summary</h3>
                <div class="flex justify-between mb-2">
                    <span>Total Price</span>
                    <span class="font-bold text-xl text-pink-600">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('checkout') }}" class="block w-full text-center bg-[#1364FF] text-white py-3 rounded-lg font-bold mt-4">Proceed to Checkout</a>
            </div>
        </div>
    @endif
</div>
@endsection