@extends('user.layouts.app')

@section('content')

    {{-- WRAPPER UNTUK BACKGROUND BIRU MUDA (Menggunakan bg-blue-50/70 agar konsisten dengan theme terang) --}}
    <div class="bg-blue-50/70"> 
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16">
            
            {{-- Header Halaman --}}
            <div class="text-center mb-10">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Our Healthcare Catalog</h1>
                <p class="text-xl text-gray-600">Find the essential wellness products you need.</p>
            </div>

            {{-- Search & Filter Section --}}
            <div class="mb-10 p-6 bg-white rounded-xl shadow-lg border border-gray-100">
                <form action="{{ route('products') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    
                    {{-- Search Input --}}
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search by product name, category, or indication..." 
                        value="{{ request('search') }}"
                        class="flex-grow p-3 border border-gray-300 rounded-lg focus:border-[#1364FF] focus:ring-1 focus:ring-[#1364FF]"
                    >
                    
                    {{-- Category Dropdown (Diperbarui dengan semua kategori) --}}
                    <select name="category" class="p-3 border border-gray-300 rounded-lg focus:border-[#1364FF] focus:ring-1 focus:ring-[#1364FF] w-full md:w-auto">
                        <option value="">All Categories</option>
                        {{-- Daftar Kategori --}}
                        @php
                            $categories = [
                                'Analgesic', 'Antibiotic', 'Antidepressant', 
                                'Antidiabetic', 'Antifungal', 'Antipyretic', 
                                'Antiseptic', 'Antiviral'
                            ];
                        @endphp
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Submit Button (Menggunakan warna biru primer Anda) --}}
                    <button type="submit" class="bg-[#1364FF] hover:bg-[#1053D4] text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 w-full md:w-auto">
                        Search
                    </button>
                </form>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                
                @forelse ($items as $item)
                    {{-- Product Card --}}
                    <a href="{{ route('product.detail', $item->id) }}" class="block">
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden transform hover:shadow-xl transition duration-300 hover:scale-[1.02] h-full flex flex-col">
                            
                            {{-- Image Area --}}
                            <div class="p-4 bg-gray-50 flex justify-center items-center h-48">
                                <img 
                                    src="{{ asset($item->image_path) }}" 
                                    alt="{{ $item->name }}" 
                                    class="max-h-full object-contain"
                                >
                            </div>
                            
                            {{-- Detail Text --}}
                            <div class="p-5 flex flex-col flex-grow">
                                
                                {{-- NAMA OBAT --}}
                                <h3 class="text-lg font-bold text-gray-900 mb-1 flex-grow">{{ $item->name }}</h3>
                                
                                {{-- CATEGORY --}}
                                <span class="text-sm text-gray-500 uppercase tracking-wider mb-2">{{ $item->category }}</span>
                                
                                <div class="mt-auto pt-2 border-t border-gray-100">
                                    @php
                                        // Ambil harga (contoh: 16000) dan diskon (contoh: 12500)
                                        $finalPrice = $item->discount_price ?? $item->price;
                                        $originalPrice = $item->price;
                                        $isSale = $item->discount_price && $item->discount_price < $item->price;
                                        
                                        // Format Rupiah (0 desimal, koma sebagai pemisah desimal, titik sebagai pemisah ribuan)
                                        // Catatan: Jika Anda ingin menggunakan desimal 2 angka: number_format(..., 2, ',', '.')
                                        $formatPrice = fn($p) => 'Rp' . number_format($p, 0, ',', '.');
                                    @endphp

                                    {{-- Harga Asli (jika ada diskon) --}}
                                    @if ($isSale)
                                        {{-- Harga Asli Abu-abu (line-through) --}}
                                        <span class="text-sm text-gray-400 line-through mr-2">{{ $formatPrice($originalPrice) }}</span>
                                    @endif
                                    
                                    {{-- Harga Final --}}
                                    <span class="text-xl font-extrabold {{ $isSale ? 'text-pink-600' : 'text-gray-900' }}">
                                        {{ $formatPrice($finalPrice) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    {{-- Jika tidak ada produk yang ditemukan --}}
                    <div class="md:col-span-4 text-center p-12 bg-yellow-50 rounded-xl">
                        <p class="text-xl text-gray-700 font-medium">No products found matching your criteria.</p>
                        <p class="text-gray-500 mt-2">Try adjusting your search filters or check back later!</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination Links --}}
            <div class="mt-12">
                {{ $items->links() }}
            </div>
            
        </div>
    </div>

@endsection