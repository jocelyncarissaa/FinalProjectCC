@extends('user.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 min-h-[75vh]">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Your Shopping Cart</h1>
        <a href="{{ route('products') }}" class="text-[#1364FF] font-semibold hover:underline flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Continue Shopping
        </a>
    </div>

    @if($cartItems->isEmpty())
        <div class="bg-blue-50 p-12 text-center rounded-3xl border border-blue-100 shadow-sm">
            <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <p class="text-xl text-gray-600 mb-6">Your cart is empty.</p>
            <a href="{{ route('products') }}" class="inline-block bg-[#1364FF] hover:bg-[#1053D4] text-white px-10 py-3 rounded-xl transition-all shadow-lg font-bold">
                Start Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" id="cart-container">
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $cart)
                    <div id="item-row-{{ $cart->item_id }}" class="bg-blue-50 border border-blue-100 rounded-2xl p-5 flex flex-col md:flex-row items-center justify-between shadow-sm transition-all duration-300">
                        
                        <div class="flex items-center space-x-6 w-full">
                            <div class="w-24 h-24 bg-white rounded-xl flex items-center justify-center p-2 border border-blue-50 shadow-inner">
                                <img src="{{ asset($cart->item->image_path) }}" class="max-h-full object-contain" alt="{{ $cart->item->name }}">
                            </div>
                            
                            <div class="flex-grow">
                                <h3 class="text-lg font-bold text-gray-900">{{ $cart->item->name }}</h3>
                                <p class="text-xs text-[#1364FF] font-bold uppercase tracking-widest mb-3">{{ $cart->item->category }}</p>
                                
                                <div class="flex items-center space-x-3 mt-2">
                                    <button type="button" onclick="changeQty({{ $cart->item_id }}, -1)" class="w-9 h-9 flex items-center justify-center bg-white border border-blue-200 rounded-lg text-blue-600 hover:bg-[#1364FF] hover:text-white transition-all font-bold shadow-sm">-</button>
                                    
                                    <span id="qty-{{ $cart->item_id }}" 
                                          data-price="{{ $cart->item->discount_price ?? $cart->item->price }}" 
                                          class="font-extrabold text-gray-800 w-8 text-center text-lg">
                                        {{ $cart->quantity }}
                                    </span>
                                    
                                    <button type="button" onclick="changeQty({{ $cart->item_id }}, 1)" class="w-9 h-9 flex items-center justify-center bg-white border border-blue-200 rounded-lg text-blue-600 hover:bg-[#1364FF] hover:text-white transition-all font-bold shadow-sm">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-4 md:mt-0 flex flex-col items-end min-w-[160px]">
                            <p class="text-xl font-black text-[#1364FF]" id="subtotal-{{ $cart->item_id }}">
                                Rp{{ number_format(($cart->item->discount_price ?? $cart->item->price) * $cart->quantity, 0, ',', '.') }}
                            </p>
                            
                            <form action="{{ route('cart.remove', $cart->id) }}" method="POST" class="mt-3">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 text-xs font-bold uppercase tracking-tighter flex items-center transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-100 shadow-2xl rounded-3xl p-8 sticky top-10">
                    <h3 class="text-2xl font-bold mb-6 text-gray-900 border-b pb-4">Order Summary</h3>
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center text-gray-600">
                            <span class="font-medium">Subtotal</span>
                            <span id="subtotal-all" class="font-bold">Rp{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t">
                            <span class="text-gray-900 font-bold text-lg">Total Price</span>
                            <span class="font-black text-2xl text-pink-600" id="grand-total">
                                Rp{{ number_format($total, 0, '.') }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('checkout') }}" class="group block w-full bg-[#1364FF] hover:bg-[#1053D4] text-white text-center py-4 rounded-2xl font-bold text-lg shadow-xl shadow-blue-100 transition-all duration-300 transform hover:-translate-y-1">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function formatRupiah(number) {
    return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
}

function changeQty(itemId, amount) {
    const qtyElement = document.getElementById(`qty-${itemId}`);
    const subtotalItemElement = document.getElementById(`subtotal-${itemId}`);
    const itemPrice = parseInt(qtyElement.getAttribute('data-price'));
    
    fetch("{{ route('cart.add') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "X-Requested-With": "XMLHttpRequest" // Penting agar Controller mengenali AJAX
        },
        body: JSON.stringify({ item_id: itemId, quantity: amount })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'updated') {
            qtyElement.innerText = data.new_qty;
            const newSubtotalItem = data.new_qty * itemPrice;
            subtotalItemElement.innerText = formatRupiah(newSubtotalItem);
            updateGrandTotal();
        } else if (data.status === 'removed') {
            const row = document.getElementById(`item-row-${itemId}`);
            row.style.transform = 'scale(0.95)';
            row.style.opacity = '0';
            setTimeout(() => {
                row.remove();
                updateGrandTotal();
                if (document.querySelectorAll('[id^="item-row-"]').length === 0) {
                    window.location.reload();
                }
            }, 300);
        }
    });
}

function updateGrandTotal() {
    let total = 0;
    document.querySelectorAll('[id^="qty-"]').forEach(el => {
        const qty = parseInt(el.innerText);
        const price = parseInt(el.getAttribute('data-price'));
        total += (qty * price);
    });
    const formatted = formatRupiah(total);
    document.getElementById('grand-total').innerText = formatted;
    document.getElementById('subtotal-all').innerText = formatted;
}
</script>
@endsection