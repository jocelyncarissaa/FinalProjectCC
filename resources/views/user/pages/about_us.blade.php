@extends('user.layouts.app')

@section('content')

    {{-- Hero Section: About Us (KONTEN LEBIH SINGKAT) --}}
    <div class="bg-blue-50 pt-24 pb-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto text-center">
                <p class="text-pink-600 font-semibold mb-3 tracking-widest uppercase text-sm">Our Commitment to You</p> 
                <h1 class="text-6xl lg:text-7xl font-extrabold leading-tight text-gray-900 mb-6">
                    Beyond Convenience: Trust Delivered
                </h1>
                <p class="text-gray-600 text-xl mb-8 max-w-2xl mx-auto">
                    Thousands rely on PharmaPlus for guaranteed quality, unparalleled speed, and seamless access to every essential health item.
                </p>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Section 1: The PharmaPlus Advantage (Quality & Logistics Focus - TETAP) --}}
        <section class="py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                
                <div class="order-2 md:order-1">
                    <span class="text-pink-600 font-bold mb-3 block uppercase text-sm tracking-widest">Our Unwavering Focus</span>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">
                        Why Settle for Less When Your Health is at Stake?
                    </h2>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        PharmaPlus prioritizes two non-negotiable factors: **Certified Product Integrity** and **Flawless Supply Chain Logistics**. We deliver confidence, not just products.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Our internal systems are engineered for **scalability**, guaranteeing that even during peak demand, your essential orders are processed and dispatched within hours, not days. We are the reliable bridge between your needs and guaranteed wellness products.
                    </p>
                </div>
                
                <div class="order-1 md:order-2">
                    <div class="h-[400px] rounded-2xl shadow-xl overflow-hidden relative">
                        {{-- Menggunakan path image/about/ourstory.jpg --}}
                        <img src="{{ asset('images/about/ourstory.jpg') }}" alt="PharmaPlus Team Working" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </section>
        
        <hr class="my-10">
        
        {{-- Section 2: Mission & Vision (LEBIH VISUAL DAN RINGKAS) --}}
        <section class="py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                
                {{-- Text: Core Principles --}}
                <div class="order-2 md:order-1">
                    <span class="text-pink-600 font-bold mb-3 block uppercase text-sm tracking-widest">Our Principles</span>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">
                        Mission-Driven, Future-Focused
                    </h2>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        We aim to set the national standard for digital health retail. Our core mission is built on ensuring quick access to verified medical and wellness products, making health access a seamless reality for everyone.
                    </p>
                    
                    <ul class="mt-6 space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-3 mt-1">&#x2713;</span>
                            <p class="font-semibold">Precision Logistics: Fast and reliable delivery, always.</p>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-3 mt-1">&#x2713;</span>
                            <p class="font-semibold">Product Integrity: Guaranteed authenticity and quality control.</p>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-3 mt-1">&#x2713;</span>
                            <p class="font-semibold">Scalable Inventory: Comprehensive stock availability for high demand.</p>
                        </li>
                    </ul>
                </div>

                {{-- Image Placeholder for Vision/Mission --}}
                <div class="order-1 md:order-2">
                    <div class="h-[400px] rounded-2xl shadow-xl overflow-hidden relative bg-blue-100 flex items-center justify-center">
                        <img src="{{ asset('images/about/mission_vision.jpg') }}" alt="Future of Access" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </section>

        <hr class="my-10">
        
        {{-- Section 3: Urgent Contact & Hours (TETAP SAMA, KARENA RINGKAS) --}}
        <section class="py-16">
            <div class="text-center mb-12">
                <span class="text-pink-600 font-bold mb-3 block uppercase text-sm tracking-widest">Contact & Logistics</span>
                <h2 class="text-4xl font-extrabold text-gray-900">
                    Need Immediate Support? We're Here.
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- Column 1: Urgent Contact --}}
                <div class="p-8 bg-white rounded-xl shadow-lg border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Urgent Order Support</h3>
                    <p class="text-gray-600 mb-4">
                        For immediate inquiries regarding fulfillment or delivery status.
                    </p>
                    <div class="space-y-3">
                        <p class="text-lg font-semibold text-gray-700">
                            Email Support: <a href="mailto:urgent@pharmaplus.com" class="text-blue-600 hover:underline">urgent@pharmaplus.com</a>
                        </p>
                        <p class="text-lg font-semibold text-gray-700">
                            WhatsApp/Call: <a href="tel:+628123456789" class="text-blue-600 hover:underline">+62 812 3456 789</a>
                        </p>
                        <p class="text-sm text-pink-600">
                            (24/7 priority line for active order tracking only)
                        </p>
                    </div>
                </div>

                {{-- Column 2: Working Hours --}}
                <div class="p-8 bg-white rounded-xl shadow-lg border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Customer Service Hours</h3>
                    <ul class="text-gray-700 space-y-2">
                        <li>Monday - Friday: <span class="font-semibold float-right">8:00 AM - 5:00 PM (WIB)</span></li>
                        <li>Saturday: <span class="font-semibold float-right">9:00 AM - 1:00 PM (WIB)</span></li>
                        <li>Sunday/Public Holiday: <span class="font-semibold float-right text-red-500">Closed</span></li>
                    </ul>
                    <p class="mt-4 text-sm text-gray-500">
                        Our administrative team is available during these hours.
                    </p>
                </div>

                {{-- Column 3: Delivery Schedule --}}
                <div class="p-8 bg-white rounded-xl shadow-lg border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Standard Shipping Cut-offs</h3>
                    <p class="text-gray-700 mb-2 font-semibold">
                        Orders are processed multiple times daily for optimal speed.
                    </p>
                    <ul class="text-gray-700 space-y-2">
                        <li>Same-Day Dispatch Cut-off: <span class="font-semibold float-right">3:00 PM</span></li>
                        <li>Next-Day Dispatch Cut-off: <span class="font-semibold float-right">10:00 PM</span></li>
                    </ul>
                    <p class="mt-4 text-sm text-gray-500">
                        We maintain robust logistics to minimize transit times nationwide.
                    </p>
                </div>
            </div>
        </section>

    </div>

@endsection