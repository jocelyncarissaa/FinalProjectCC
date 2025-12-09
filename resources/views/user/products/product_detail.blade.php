@extends('user.layouts.app')

@section('content')

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16">
        
        {{-- Header Halaman --}}
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Our Healthcare Catalog</h1>
            <p class="text-xl text-gray-600">Find the essential wellness products you need.</p>
        </div>

        {{-- Search & Filter Section --}}
        <div class="mb-10 p-6 bg-gray-50 rounded-xl shadow-inner border border-gray-100">
            <form action="{{ route('products') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                
                {{-- Search Input --}}
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search by product name, category, or indication..." 
                    value="{{ request('search') }}"
                    class="flex-grow p-3 border border-gray-300 rounded-lg focus:border-[#1364FF] focus:ring-1 focus:ring-[#1364FF]"
                >
                
                {{-- Category Dropdown (Contoh) --}}
                <select name="category" class="p-3 border border-gray-300 rounded-lg focus:border-[#1364FF] focus:ring-1 focus:ring-[#1364FF] w-full md:w-auto">
                    <option value="">All Categories</option>
                    <option value="Analgesic" {{ request('category') == 'Analgesic' ? 'selected' : '' }}>Analgesics</option>
                    <option value="Antibiotic" {{ request('category') == 'Antibiotic' ? 'selected' : '' }}>Antibiotics</option>
                    <option value="Antifungal" {{ request('category') == 'Antifungal' ? 'selected' : '' }}>Antifungal</option>
                    {{-- TODO: Loop daftar kategori dari DB --}}
                </select>

                {{-- Submit Button --}}
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
                            <span class="text-xs text-gray-500 uppercase tracking-wider mb-1">{{ $item->category }}</span>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 flex-grow">{{ $item->name }}</h3>
                            
                            <div class="mt-auto">
                                {{-- Harga Asli (jika ada diskon) --}}
                                @if ($item->discount_price && $item->discount_price < $item->price)
                                    <span class="text-sm text-gray-400 line-through mr-2">${{ number_format($item->price, 2) }}</span>
                                @endif
                                
                                {{-- Harga Final --}}
                                <span class="text-xl font-bold text-pink-600">
                                    ${{ number_format($item->discount_price ?? $item->price, 2) }}
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

@endsection