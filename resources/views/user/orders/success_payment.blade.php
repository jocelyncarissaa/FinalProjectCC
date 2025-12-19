@extends('user.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-3xl shadow-2xl border border-gray-100 text-center">
        <div class="flex justify-between items-center mb-8 text-left">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Order #{{ $order->id }}</h2>
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            {{-- Menggunakan Accessor dari Model Order --}}
            <span class="px-4 py-1 rounded-full text-xs font-black uppercase tracking-tighter" style="{{ $order->status_badge_class }}">
                {{ $order->status }}
            </span>
        </div>

        <div class="space-y-4 mb-8 text-left">
            <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest">Items Purchased</h3>
            
            {{-- Menggunakan orderDetails sesuai relasi di Model & Controller --}}
            @foreach($order->orderDetails as $detail)
            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-2xl">
                <div class="flex items-center space-x-4">
                    {{-- KEMBALI KE AWAL: Menggunakan asset() untuk memanggil image_path --}}
                    <img src="{{ asset($detail->item->image_path) }}" 
                         class="w-12 h-12 object-contain bg-white rounded-lg p-1 border"
                         alt="{{ $detail->item->name }}">
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">{{ $detail->item->name }}</h4>
                        <p class="text-xs text-gray-400">{{ $detail->quantity }} x Rp{{ number_format($detail->price_per_unit, 0, ',', '.') }}</p>
                    </div>
                </div>
                <p class="font-black text-[#1364FF]">Rp{{ number_format($detail->quantity * $detail->price_per_unit, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>

        <div class="border-t border-gray-100 pt-6 mb-8">
            <div class="flex justify-between items-center">
                <span class="text-gray-400 font-bold uppercase text-xs tracking-widest">Grand Total</span>
                <span class="text-3xl font-black text-gray-900">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="space-y-4">
            <button class="w-full bg-[#1364FF] hover:bg-[#1053D4] text-white py-5 rounded-2xl font-black text-xl shadow-xl shadow-blue-100 transition-all transform hover:-translate-y-1">
                PAY NOW
            </button>
            <a href="{{ route('products') }}" class="block text-gray-400 font-bold hover:text-gray-600 transition-colors">
                Back to Shopping
            </a>
        </div>
    </div>
</div>
@endsection