@extends('user.layouts.app')

@section('content')

    <div class="bg-hero-bg">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16">

            {{-- Header --}}
            <div class="text-center mb-10">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Our Healthcare Catalog</h1>
                <p class="text-xl text-gray-600">Find the essential wellness products you need.</p>
            </div>

            {{-- Search & Filter Section --}}
            <div class="mb-10 p-6 bg-white rounded-xl shadow-lg border border-gray-100">
                {{-- <form action="{{ route('products') }}" method="GET" class="flex flex-col md:flex-row gap-4"> --}}
                <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search by product name, category, or indication..."
                        value="{{ request('search') }}"
                        class="flex-grow p-3 border border-gray-300 rounded-lg focus:border-[#1364FF] focus:ring-1 focus:ring-[#1364FF]"
                    >

                    <select name="category" class="p-3 border border-gray-300 rounded-lg focus:border-[#1364FF] focus:ring-1 focus:ring-[#1364FF] w-full md:w-auto">
                        <option value="">All Categories</option>
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

                    <button type="submit" class="bg-[#1364FF] hover:bg-[#1053D4] text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 w-full md:w-auto">
                        Search
                    </button>
                </form>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

                @forelse ($items as $item)
                    @php
                        $finalPrice = $item->discount_price ?? $item->price;
                        $originalPrice = $item->price;
                        $isSale = $item->discount_price && $item->discount_price < $item->price;
                        $formatPrice = fn($p) => 'Rp' . number_format($p, 0, ',', '.');
                    @endphp

                    {{-- Product Card (Seluruh area card memicu modal) --}}
                    <div
                        data-id="{{ $item->id }}"
                        data-name="{{ $item->name }}"
                        data-category="{{ $item->category }}"
                        data-price="{{ $finalPrice }}"
                        class="open-cart-modal bg-gray-50 rounded-xl shadow-lg border border-gray-100 overflow-hidden transform hover:shadow-xl transition duration-300 hover:scale-[1.02] h-full flex flex-col relative group cursor-pointer"
                    >

                        {{-- Icon Hover Indikator --}}
                        <div class="absolute top-3 right-3 w-10 h-10 bg-pink-600 text-white rounded-full flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-opacity z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>

                       blade
                            @if($item->image_path)
                                <img 
                                    src="{{ env('S3_BUCKET_URL') }}/{{ $item->image_path }}" 
                                    alt="{{ $item->name }}" 
                                    class="max-h-full object-contain"
                                >
                            @else
                                <div class="text-gray-400 text-xs">No Image</div>
                            @endif
    

                        {{-- Detail Text --}}
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-1 flex-grow">{{ $item->name }}</h3>
                            <span class="text-sm text-gray-500 uppercase tracking-wider mb-2">{{ $item->category }}</span>

                            <div class="mt-auto pt-2 border-t border-gray-100">
                                @if ($isSale)
                                    <span class="text-sm text-gray-400 line-through mr-2">{{ $formatPrice($originalPrice) }}</span>
                                @endif
                                <span class="text-xl font-extrabold {{ $isSale ? 'text-pink-600' : 'text-gray-900' }}">
                                    {{ $formatPrice($finalPrice) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
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

    {{-- =============================================== --}}
    {{-- MODAL ADD TO CART --}}
    {{-- =============================================== --}}
    <div id="cart-modal" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 md:p-8 transform transition-all">

            <h3 class="text-2xl font-bold text-gray-900 mb-4 border-b pb-2">Add Item to Cart</h3>

            {{-- ACTION diarahkan ke route POST cart.add --}}
            <form id="add-to-cart-form" method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="item_id" id="modal-item-id">

                <div class="mb-5 space-y-2">
                    <p class="text-sm text-gray-500">Product Name:</p>
                    <h4 id="modal-item-name" class="text-xl font-extrabold text-[#1364FF]"></h4>
                    <p class="text-md text-gray-600">Category: <span id="modal-item-category" class="font-semibold text-pink-600"></span></p>
                    <p class="text-md text-gray-600">Price: <span id="modal-item-price" class="font-bold text-gray-900"></span></p>
                </div>

                <div class="mb-5">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                    <div class="flex items-center space-x-3">
                        <button type="button" id="decrement-qty" class="w-10 h-10 bg-gray-200 rounded-lg hover:bg-gray-300 font-bold text-xl transition">-</button>
                        <input type="number" name="quantity" id="modal-quantity" value="1" min="1" class="w-20 p-2 border border-gray-300 rounded-lg text-center focus:border-[#1364FF] focus:ring-1 focus:ring-[#1364FF]">
                        <button type="button" id="increment-qty" class="w-10 h-10 bg-gray-200 rounded-lg hover:bg-gray-300 font-bold text-xl transition">+</button>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Special Notes (Optional)</label>
                    <textarea name="notes" id="modal-notes" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:border-[#1364FF] focus:ring-1 focus:ring-[#1364FF]" placeholder="e.g., Packaging instructions, special delivery time..."></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancel-cart-modal" class="py-2 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                        Cancel
                    </button>
                    <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition">
                        Add to Cart
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('cart-modal');
            const openButtons = document.querySelectorAll('.open-cart-modal');
            const cancelButton = document.getElementById('cancel-cart-modal');
            const qtyInput = document.getElementById('modal-quantity');
            const incrementBtn = document.getElementById('increment-qty');
            const decrementBtn = document.getElementById('decrement-qty');

            openButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const category = this.getAttribute('data-category');
                    const price = this.getAttribute('data-price');

                    document.getElementById('modal-item-id').value = id;
                    document.getElementById('modal-item-name').textContent = name;
                    document.getElementById('modal-item-category').textContent = category;

                    const formattedPrice = 'Rp' + parseFloat(price).toLocaleString('id-ID', { minimumFractionDigits: 0 });
                    document.getElementById('modal-item-price').textContent = formattedPrice;

                    qtyInput.value = 1;
                    document.getElementById('modal-notes').value = '';

                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                });
            });

            const closeModal = () => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            };

            cancelButton.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            incrementBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                qtyInput.value = parseInt(qtyInput.value) + 1;
            });

            decrementBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                let currentVal = parseInt(qtyInput.value);
                if (currentVal > 1) {
                    qtyInput.value = currentVal - 1;
                }
            });

            qtyInput.addEventListener('change', () => {
                if (parseInt(qtyInput.value) < 1 || isNaN(parseInt(qtyInput.value))) {
                    qtyInput.value = 1;
                }
            });
        });
    </script>

@endsection
