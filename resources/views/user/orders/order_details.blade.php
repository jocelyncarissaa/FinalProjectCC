@extends('user.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        {{-- Header & Back Button --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('profile') }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-[#1364FF] hover:border-[#1364FF] transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Order Details</h1>
                    <p class="text-sm text-gray-500">Order ID: <span class="font-mono text-[#1364FF] font-bold">#{{ $order->id }}</span></p>
                </div>
            </div>

            {{-- Status Badge --}}
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 rounded-lg text-sm font-bold uppercase tracking-wide shadow-sm" style="{{ $order->status_badge_class }}">
                    {{ $order->status }}
                </span>
                <span class="text-gray-400 text-sm font-medium">
                    {{ $order->created_at->format('d F Y, H:i') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- LEFT COLUMN: Order Items --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 font-bold text-gray-700">
                        Items Purchased
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        {{-- Loop through OrderDetails --}}
                        @foreach($order->items as $detail)
                        <div class="p-6 flex flex-col sm:flex-row items-center sm:items-start gap-4 hover:bg-gray-50 transition">
                            
                            {{-- Item Image --}}
                            <div class="w-20 h-20 bg-gray-200 rounded-lg flex-shrink-0 overflow-hidden border border-gray-200">
                                @if($detail->item && $detail->item->image_path)
                                    <img src="{{ asset('storage/' . $detail->item->image_path) }}" alt="{{ $detail->item->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 text-center sm:text-left">
                                {{-- Item Name --}}
                                <h3 class="text-lg font-bold text-gray-800">
                                    {{ $detail->item->name ?? 'Item Unavailable' }}
                                </h3>
                                
                                {{-- Manufacturer / Strength (Optional, based on your Item model) --}}
                                <p class="text-sm text-gray-500 mb-2">
                                    {{ $detail->item->manufacturer ?? '' }} 
                                    @if(isset($detail->item->strength)) • {{ $detail->item->strength }} @endif
                                </p>

                                <div class="font-mono text-sm text-gray-600">
                                    {{ $detail->quantity }} x Rp {{ number_format($detail->item->price, 0, ',', '.') }}
                                </div>
                            </div>

                            <div class="text-right">
                                <p class="text-lg font-bold text-[#1364FF]">
                                    Rp {{ number_format($detail->item->price * $detail->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Customer & Payment Info --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Shipping Information --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-gray-500 uppercase text-xs font-bold tracking-wider mb-4">Shipping Details</h3>
                    
                    <div class="flex items-start gap-3 mb-4">
                        <div class="p-2 bg-blue-50 text-[#1364FF] rounded-lg mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-gray-600 text-sm leading-relaxed mt-1">
                                {{ $order->shipping_address ?? 'No shipping address provided.' }}
                            </p>
                            <p class="text-gray-500 text-sm mt-2">{{ $order->user->phone }}</p>
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h3 class="text-gray-500 uppercase text-xs font-bold tracking-wider mb-4">Payment Summary</h3>
                    
                    {{-- CALCULATE TOTAL DYNAMICALLY --}}
                    @php
                        $calculatedTotal = 0;
                        foreach($order->items as $detail) {
                            // Ensure we use the same price logic as the item list (item->price)
                            $itemPrice = $detail->item->price ?? 0;
                            $calculatedTotal += $itemPrice * $detail->quantity;
                        }
                    @endphp

                    <div class="space-y-3 pb-4 border-b border-gray-100">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal</span>
                            {{-- Use the calculated variable --}}
                            <span>Rp {{ number_format($calculatedTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Shipping Fee</span>
                            <span>Rp 0</span> 
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4">
                        <span class="font-bold text-gray-800 text-lg">Total</span>
                        <span class="font-bold text-2xl text-[#1364FF]">
                            {{-- Use the calculated variable --}}
                            Rp {{ number_format($calculatedTotal, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                @if($order->status === 'pending')
                    <button class="w-full py-3 bg-[#1364FF] text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Pay Now
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection