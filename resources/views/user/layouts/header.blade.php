<header class="bg-white sticky top-0 z-50 shadow-md">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center justify-between h-20">

            <div class="flex items-center">
                <div class="w-8 h-8 bg-[#1364FF] rounded-full flex items-center justify-center text-white font-bold text-lg mr-2">P</div>
                <a href="{{ url('/') }}" class="text-2xl font-extrabold text-[#1364FF] hover:text-[#1053D4] transition">PharmaPlus</a>
            </div>

            <div class="hidden md:flex items-center space-x-8 text-gray-800">
                <a href="{{ url('/') }}" class="font-medium hover:text-[#1053D4] transition">Home</a>
                <a href="{{ url('/about-us') }}" class="font-medium hover:text-[#1053D4] transition">About Us</a>
                <a href="{{ url('/contact-us') }}" class="font-medium hover:text-[#1053D4] transition">Contact Us</a>
            </div>

            <div class="flex items-center space-x-3">

                <a href="{{ url('/register') }}" class="text-white bg-[#1364FF] hover:bg-[#1053D4] font-bold py-2 px-5 rounded-lg shadow-md transition-all duration-300">
                    Register
                </a>

                <a href="{{ url('/login') }}" class="text-[#1364FF] border border-[#1364FF] hover:bg-blue-50 font-bold py-2 px-5 rounded-lg transition-all duration-300">
                    Login
                </a>

            </div>

            </nav>
    </div>
</header>
