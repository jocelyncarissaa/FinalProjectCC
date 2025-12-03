@extends('user.layouts.app')

@section('content')

    <div class="bg-hero-bg pt-24 pb-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <section class="pb-8 pt-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-12">
                    
                    <div class="w-full md:w-1/2 pr-0 md:pr-10 mb-8 md:mb-0">
                        <p class="text-pink-600 font-semibold mb-3 tracking-widest uppercase text-sm">PharmaPlus Store</p> 
                        <h1 class="text-6xl lg:text-7xl font-extrabold leading-tight text-gray-900 mb-6">
                            Your Health, <br> Our Priority.
                        </h1>
                        <p class="text-gray-600 text-lg mb-8 max-w-md">
                            Discover a seamless healthcare experience with PharmaPlus. Your wellness journey starts here, with trusted products and expert care delivered right to your door.
                        </p>
                        
                        <div class="flex items-center space-x-6">
                            <div class="flex -space-x-3">
                                <div class="w-12 h-12 bg-indigo-400 rounded-full border-2 border-hero-bg shadow-lg"></div>
                                <div class="w-12 h-12 bg-blue-400 rounded-full border-2 border-hero-bg shadow-lg"></div>
                                <div class="w-12 h-12 bg-green-400 rounded-full border-2 border-hero-bg shadow-lg"></div>
                            </div>
                            <div class="pl-4">
                                <p class="text-2xl font-bold text-gray-900">100k+</p>
                                <p class="text-sm text-gray-600">Satisfied Customers</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-1/2">
                        <div class="bg-gray-800 h-[550px] rounded-[30px] shadow-2xl flex items-start justify-end p-8 relative overflow-hidden">
                            
                            <div class="absolute top-8 right-8 space-y-3">
                                <div class="w-3 h-3 bg-white rounded-full"></div>
                                <div class="w-3 h-3 bg-white/50 rounded-full"></div>
                            </div>
                            
                            <img src="{{ asset('images/homepage/pharmaplus.jpg') }}" alt="PharmaPlus Product Image" class="absolute inset-0 w-full h-full object-cover rounded-[30px]">
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <section class="mb-16 pt-8"> 
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-hero-bg p-8 rounded-xl shadow-lg flex items-center justify-between transition duration-300 transform group hover:shadow-2xl hover:scale-[1.01]">
                    <div>
                        <span class="text-pink-600 font-bold mb-2 block">Big Sale</span>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Get an Extra <br><span class="text-indigo-600">50% Off</span></h2>
                        <p class="text-gray-500 max-w-xs">Upgrade your self-care routine! Limited time offer on select supplements and personal care essentials.</p>
                    </div>
                    <div class="w-2/5 h-40 rounded-lg relative overflow-hidden bg-gray-800">
                        <img src="{{ asset('images/homepage/healthcarecompanylogo.jpg') }}" alt="Healthcare Company Logo" class="absolute inset-0 w-full h-full object-contain p-4 filter grayscale">
                    </div>
                </div>
    
                <div class="bg-blue-700 p-8 rounded-xl shadow-lg flex items-center justify-between transition duration-300 transform group hover:shadow-2xl hover:scale-[1.01]">
                    <div>
                        <span class="text-white font-semibold mb-2 block">Holiday Savings</span>
                        <h2 class="text-6xl font-extrabold text-white mb-4">Up to 40%</h2>
                        <button class="bg-white text-blue-700 font-bold py-2 px-4 rounded-full hover:bg-gray-100 transition duration-200 text-sm mb-1">Shop Now</button>
                    </div>
                    <div class="w-2/5 h-40 rounded-lg relative overflow-hidden bg-gray-900 opacity-90">
                        <img src="{{ asset('images/homepage/christmassale.jpg') }}" alt="Christmas Sale Banner" class="absolute inset-0 w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </section>
    
        <section class="mb-16">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <span class="text-pink-600 font-bold mb-1 block">Featured</span>
                    <h2 class="text-3xl font-extrabold text-gray-900">Top Picks for Your Wellness</h2>
                    <p class="text-gray-500 max-w-lg mt-2">Curated selection of essential health products recommended by our experts.</p>
                </div>
                <a href="#" class="text-blue-600 font-semibold hover:text-blue-800 transition duration-150 hidden sm:block">All Products &rarr;</a>
            </div>
    
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                
                {{-- Card 1: Clarinazole --}}
                <div class="bg-blue-50 p-4 rounded-xl shadow-lg transition duration-300 transform hover:shadow-xl hover:scale-[1.03] cursor-pointer">
                    <div class="bg-hero-bg h-48 rounded-lg mb-4 relative flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/homepage/Clarinazole.jpg') }}" alt="Acetaminophen Pills" class="w-full h-full object-contain p-4">
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900">Clarinazole</h3>
                    <p class="text-gray-500 text-sm">Antifungal</p>
                    <div class="mt-2">
                        <span class="text-gray-400 line-through mr-2">$16.00</span>
                        <span class="text-red-600 font-bold">$12.50</span>
                    </div>
                </div>
    
                {{-- Card 2: Cefcillin --}}
                <div class="bg-blue-50 p-4 rounded-xl shadow-lg transition duration-300 transform hover:shadow-xl hover:scale-[1.03] cursor-pointer">
                    <div class="bg-hero-bg h-48 rounded-lg mb-4 relative flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/homepage/Cefcillin.jpg') }}" alt="Throat Lozenges Syrup" class="w-full h-full object-contain p-4">
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900">Cefcillin</h3>
                    <p class="text-gray-500 text-sm">Antipyretic</p>
                    <div class="mt-2">
                        <span class="text-gray-400 line-through mr-2">$16.00</span>
                        <span class="text-red-600 font-bold">$12.00</span>
                    </div>
                </div>
    
                {{-- Card 3: Ibupronazole --}}
                <div class="bg-blue-50 p-4 rounded-xl shadow-lg transition duration-300 transform hover:shadow-xl hover:scale-[1.03] cursor-pointer">
                    <div class="bg-hero-bg h-48 rounded-lg mb-4 relative flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/homepage/Ibupronazole.jpg') }}" alt="Multivitamin B6+" class="w-full h-full object-contain p-4">
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900">Ibupronazole</h3>
                    <p class="text-gray-500 text-sm">Analgesic</p>
                    <div class="mt-2">
                        <span class="text-gray-400 line-through mr-2">$18.99</span>
                        <span class="text-red-600 font-bold">$12.00</span>
                    </div>
                </div>
                
                {{-- Card 4: Metoprofen --}}
                <div class="bg-blue-50 p-4 rounded-xl shadow-lg transition duration-300 transform hover:shadow-xl hover:scale-[1.03] cursor-pointer">
                    <div class="bg-hero-bg h-48 rounded-lg mb-4 relative flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/homepage/Metoprofen.jpg') }}" alt="Dental Floss" class="w-full h-full object-contain p-4">
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900">Metoprofen</h3>
                    <p class="text-gray-500 text-sm">Antiseptic</p>
                    <div class="mt-2">
                        <span class="text-red-600 font-bold">$5.50</span>
                    </div>
                </div>
    
            </div>
            
            <div class="flex justify-end mt-4">
                <a href="#" class="text-blue-600 font-semibold hover:text-blue-800 transition duration-150 sm:hidden">All Products &rarr;</a>
            </div>
        </section>
    
        <section class="mb-16">
            <h2 class="sr-only">Product Categories</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="relative bg-white p-6 rounded-xl shadow-lg h-64 overflow-hidden 
                            transition-transform duration-300 transform hover:shadow-xl hover:scale-[1.02]">
                    <div class="relative z-10 w-1/2">
                        <h3 class="text-2xl font-bold mb-2 text-gray-900">Antidiabetic</h3>
                        <p class="text-gray-600">
                           Helps support healthy blood sugar management and promotes better daily wellness.
                        </p>
                        <a href="#" class="text-blue-600 font-semibold mt-4 block hover:text-blue-800">
                            Explore Category →
                        </a>
                    </div>
                    <div class="absolute top-0 right-0 w-1/2 h-full rounded-l-xl overflow-hidden">
                        <img 
                            src="/images/homepage/antidiabetic.jpg" 
                            alt="Antidiabetic Medicine" 
                            class="w-full h-full object-cover"
                        >
                    </div>
                </div>

                <div class="relative bg-white p-6 rounded-xl shadow-lg h-64 overflow-hidden 
                            transition-transform duration-300 transform hover:shadow-xl hover:scale-[1.02]">
                    <div class="relative z-10 w-1/2">
                        <h3 class="text-2xl font-bold mb-2 text-gray-900">Antiseptic</h3>
                        <p class="text-gray-600">
                           Helps protect the skin by reducing harmful germs and supporting everyday hygiene.
                        </p>
                        <a href="#" class="text-blue-600 font-semibold mt-4 block hover:text-blue-800">
                            Explore Category →
                        </a>
                    </div>
                    <div class="absolute top-0 right-0 w-1/2 h-full rounded-l-xl overflow-hidden">
                        <img 
                            src="/images/homepage/antiseptic.jpg" 
                            alt="Antidiabetic Medicine" 
                            class="w-full h-full object-cover"
                        >
                    </div>
                </div>

                <div class="relative bg-white p-6 rounded-xl shadow-lg h-64 overflow-hidden 
                            transition-transform duration-300 transform hover:shadow-xl hover:scale-[1.02]">
                    <div class="relative z-10 w-1/2">
                        <h3 class="text-2xl font-bold mb-2 text-gray-900">Antibiotic</h3>
                        <p class="text-gray-600">
                           Helps reduce bacterial growth and supports faster recovery.
                        </p>
                        <a href="#" class="text-blue-600 font-semibold mt-4 block hover:text-blue-800">
                            Explore Category →
                        </a>
                    </div>
                    <div class="absolute top-0 right-0 w-1/2 h-full rounded-l-xl overflow-hidden">
                        <img 
                            src="/images/homepage/antibiotic.jpg" 
                            alt="Antidiabetic Medicine" 
                            class="w-full h-full object-cover"
                        >
                    </div>
                </div>
                
                <div class="relative bg-white p-6 rounded-xl shadow-lg h-64 overflow-hidden 
                            transition-transform duration-300 transform hover:shadow-xl hover:scale-[1.02]">
                    <div class="relative z-10 w-1/2">
                        <h3 class="text-2xl font-bold mb-2 text-gray-900">Antifungal</h3>
                        <p class="text-gray-600">
                           Designed to combat stubborn fungal issues, helping restore comfort and skin confidence.
                        </p>
                        <a href="#" class="text-blue-600 font-semibold mt-4 block hover:text-blue-800">
                            Explore Category →
                        </a>
                    </div>
                    <div class="absolute top-0 right-0 w-1/2 h-full rounded-l-xl overflow-hidden">
                        <img 
                            src="/images/homepage/antifungal.jpg" 
                            alt="Antidiabetic Medicine" 
                            class="w-full h-full object-cover"
                        >
                    </div>
                </div>
            </div>
        </section>
    
        <section class="pb-16 pt-8">
            <div class="mb-8"> 
                <span class="text-pink-600 font-bold mb-1 block uppercase text-xs tracking-widest">Review</span>
                <h2 class="text-3xl font-extrabold text-gray-900">Testimonials That Inspire Us</h2>
                <p class="text-gray-600 max-w-xl mt-2">
                    Hear inspiring stories from customers who have experienced the real benefits of PharmaPlus.
                </p>
            </div>

            <div class="relative overflow-hidden">
                <div id="testimonial-slider" class="flex transition-transform duration-500 ease-in-out"> 
                    
                    {{-- Testimonial 1 (Content Revised, Padding Adjusted) --}}
                    <div class="min-w-full px-4 sm:px-6 lg:px-8"> 
                        <div class="cursor-pointer max-w-3xl mx-auto"> 
                            <div class="bg-white px-6 py-3 md:px-10 md:py-6 rounded-2xl shadow-xl border border-gray-100 relative">
                                <div class="absolute top-0 left-0 -ml-4 -mt-4 p-3 rounded-full bg-blue-100 border-4 border-white">
                                    <img 
                                        src="{{ asset('images/homepage/quote.png') }}" 
                                        alt="Quote Icon" 
                                        class="w-8 h-8 text-blue-500 object-contain"
                                    >
                                </div>
                                
                                <div class="relative z-10 pt-4">
                                    <p class="text-xl italic text-gray-700 leading-relaxed mb-6">
                                        “I love the ease of checkout and the fast, reliable delivery! Even during flu season, my orders arrive quickly. The product quality is consistently high.”
                                    </p>
                                    
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full mr-4 overflow-hidden"> 
                                            <img 
                                                src="{{ asset('images/homepage/lindaparker.jpg') }}" 
                                                alt="Linda Parker Profile" 
                                                class="w-full h-full object-cover"
                                            >
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">Linda Parker</p>
                                            <p class="text-sm text-gray-500">Loyal Customer, 55 years old</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Testimonial 2 (Content Revised) --}}
                    <div class="min-w-full px-4 sm:px-6 lg:px-8">
                        <div class="cursor-pointer max-w-3xl mx-auto">
                            <div class="bg-white px-6 py-3 md:px-10 md:py-6 rounded-2xl shadow-xl border border-gray-100 relative">
                                <div class="absolute top-0 left-0 -ml-4 -mt-4 p-3 rounded-full bg-blue-100 border-4 border-white">
                                    <img 
                                        src="{{ asset('images/homepage/quote.png') }}" 
                                        alt="Quote Icon" 
                                        class="w-8 h-8 text-blue-500 object-contain"
                                    >
                                </div>
                                
                                <div class="relative z-10 pt-4">
                                    <p class="text-xl italic text-gray-700 leading-relaxed mb-6">
                                        “The sheer availability of products is fantastic, and everything is always in stock. This shows great scalability and stock management. Delivery is always ahead of schedule.”
                                    </p>
                                    
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full mr-4 overflow-hidden"> 
                                            <img 
                                                src="{{ asset('images/homepage/john.jpg') }}" 
                                                alt="John B. Smith Profile" 
                                                class="w-full h-full object-cover"
                                            >
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">John B. Smith</p>
                                            <p class="text-sm text-gray-500">Subscription Holder, 20 years old</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Testimonial 3 (Content Revised) --}}
                    <div class="min-w-full px-4 sm:px-6 lg:px-8">
                        <div class="cursor-pointer max-w-3xl mx-auto">
                            <div class="bg-white px-6 py-3 md:px-10 md:py-6 rounded-2xl shadow-xl border border-gray-100 relative">
                                <div class="absolute top-0 left-0 -ml-4 -mt-4 p-3 rounded-full bg-blue-100 border-4 border-white">
                                    <img 
                                        src="{{ asset('images/homepage/quote.png') }}" 
                                        alt="Quote Icon" 
                                        class="w-8 h-8 text-blue-500 object-contain"
                                    >
                                </div>
                                
                                <div class="relative z-10 pt-4">
                                    <p class="text-xl italic text-gray-700 leading-relaxed mb-6">
                                        “Ordering my family’s medications here is worry-free. The packaging is secure, and the items are always fresh. This high quality standard is why I keep coming back.”
                                    </p>
                                    
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full mr-4 overflow-hidden"> 
                                            <img 
                                                src="{{ asset('images/homepage/sarah.jpg') }}" 
                                                alt="Sarah K. Lee Profile" 
                                                class="w-full h-full object-cover"
                                            >
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">Sarah K. Lee</p>
                                            <p class="text-sm text-gray-500">Family Health Manager</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Testimonial 4 (Content Revised) --}}
                    <div class="min-w-full px-4 sm:px-6 lg:px-8">
                        <div class="cursor-pointer max-w-3xl mx-auto">
                            <div class="bg-white px-6 py-3 md:px-10 md:py-6 rounded-2xl shadow-xl border border-gray-100 relative">
                                <div class="absolute top-0 left-0 -ml-4 -mt-4 p-3 rounded-full bg-blue-100 border-4 border-white">
                                    <img 
                                        src="{{ asset('images/homepage/quote.png') }}" 
                                        alt="Quote Icon" 
                                        class="w-8 h-8 text-blue-500 object-contain"
                                    >
                                </div>
                                
                                <div class="relative z-10 pt-4">
                                    <p class="text-xl italic text-gray-700 leading-relaxed mb-6">
                                        “During peak illness season, I was nervous about delays, but my order arrived in less than 24 hours. Incredible logistics and speed! Highly reliable platform.”
                                    </p>
                                    
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full mr-4 overflow-hidden"> 
                                            <img 
                                                src="{{ asset('images/homepage/david.jpg') }}" 
                                                alt="David M. Wong Profile" 
                                                class="w-full h-full object-cover"
                                            >
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">David M. Wong</p>
                                            <p class="text-sm text-gray-500">First-time User</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Testimonial 5 (Content Revised) --}}
                    <div class="min-w-full px-4 sm:px-6 lg:px-8">
                        <div class="cursor-pointer max-w-3xl mx-auto">
                            <div class="bg-white px-6 py-3 md:px-10 md:py-6 rounded-2xl shadow-xl border border-gray-100 relative">
                                <div class="absolute top-0 left-0 -ml-4 -mt-4 p-3 rounded-full bg-blue-100 border-4 border-white">
                                    <img 
                                        src="{{ asset('images/homepage/quote.png') }}" 
                                        alt="Quote Icon" 
                                        class="w-8 h-8 text-blue-500 object-contain"
                                    >
                                </div>
                                
                                <div class="relative z-10 pt-4">
                                    <p class="text-xl italic text-gray-700 leading-relaxed mb-6">
                                        “The system is intuitive, and they handle bulk orders flawlessly. It's clear they are built to handle high demand efficiently while maintaining product integrity.”
                                    </p>
                                    
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full mr-4 overflow-hidden"> 
                                            <img 
                                                src="{{ asset('images/homepage/eva.jpg') }}" 
                                                alt="Eva G. Rodriguez Profile" 
                                                class="w-full h-full object-cover"
                                            >
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900">Eva G. Rodriguez</p>
                                            <p class="text-sm text-gray-500">Bulk Buyer, 4 years</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="testimonial-dots" class="flex justify-center space-x-2 mt-8">
                <div class="w-3 h-3 bg-blue-600 rounded-full cursor-pointer" data-slide="0"></div>
                <div class="w-3 h-3 bg-gray-300 hover:bg-gray-400 rounded-full cursor-pointer" data-slide="1"></div>
                <div class="w-3 h-3 bg-gray-300 hover:bg-gray-400 rounded-full cursor-pointer" data-slide="2"></div>
                <div class="w-3 h-3 bg-gray-300 hover:bg-gray-400 rounded-full cursor-pointer" data-slide="3"></div>
                <div class="w-3 h-3 bg-gray-300 hover:bg-gray-400 rounded-full cursor-pointer" data-slide="4"></div>
            </div>

        </section>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slider = document.getElementById('testimonial-slider');
            if (!slider) return;

            const slides = slider.children;
            const totalSlides = slides.length;
            const dotsContainer = document.getElementById('testimonial-dots');
            const dots = dotsContainer ? dotsContainer.children : [];
            let currentSlide = 0;
            const intervalTime = 10000;

            function updateSlider() {
                const offset = -currentSlide * 100;
                slider.style.transform = `translateX(${offset}%)`;
                updateDots();
            }

            function updateDots() {
                for (let i = 0; i < dots.length; i++) {
                    if (i === currentSlide) {
                        dots[i].classList.remove('bg-gray-300', 'hover:bg-gray-400');
                        dots[i].classList.add('bg-blue-600');
                    } else {
                        dots[i].classList.remove('bg-blue-600');
                        dots[i].classList.add('bg-gray-300', 'hover:bg-gray-400');
                    }
                }
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            }

            let slideInterval = setInterval(nextSlide, intervalTime);

            for (let i = 0; i < dots.length; i++) {
                dots[i].addEventListener('click', () => {
                    clearInterval(slideInterval);
                    
                    currentSlide = i;
                    updateSlider();

                    slideInterval = setInterval(nextSlide, intervalTime);
                });
            }

            updateSlider();
        });
    </script>
@endsection