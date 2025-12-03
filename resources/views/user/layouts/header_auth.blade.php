<header class="bg-white sticky top-0 z-50 shadow-md">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center justify-between h-20">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-[#1364FF] rounded-full flex items-center justify-center text-white font-bold text-lg mr-2">P</div>
                <a href="{{ url('/') }}" class="text-2xl font-extrabold text-[#1364FF] hover:text-[#1053D4] transition">PharmaPlus</a>
            </div>

            <div class="hidden md:flex items-center space-x-8 text-gray-800">
                <a href="{{ url('/home') }}" class="font-medium hover:text-[#1053D4] transition">Home</a>
                <a href="{{ url('/products') }}" class="font-medium hover:text-[#1053D4] transition">Products</a>
                <a href="{{ url('/about-us') }}" class="font-medium hover:text-[#1053D4] transition">About Us</a>
                <a href="{{ url('/contact-us') }}" class="font-medium hover:text-[#1053D4] transition">Contact Us</a>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ url('/cart') }}" class="text-gray-600 hover:text-[#1364FF] p-2 relative transition duration-150">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="absolute top-0 right-0 w-4 h-4 bg-pink-600 text-white text-xs rounded-full flex items-center justify-center -mt-1 -mr-1">3</span>
                </a>

                <a href="{{ url('/profile') }}" class="flex items-center space-x-2 text-gray-800 hover:text-[#1364FF] font-medium transition duration-150">
                    <span class="text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                    <div class="w-8 h-8 bg-blue-100 border border-[#1364FF] rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#1364FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                </a>
            </div>

        </nav>
    </div>
</header>