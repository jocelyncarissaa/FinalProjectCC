@extends('user.layouts.app')

@section('content')
    <div class="pt-24 pb-16 bg-cover bg-center relative" style="background-image: url('{{ asset('images/homepage/aboutus.jpg') }}');">
        <div class="absolute inset-0 bg-gray-900 opacity-60"></div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <p class="text-pink-400 font-semibold mb-3 tracking-widest uppercase text-sm">Our Commitment to You</p> 
                <h1 class="text-6xl lg:text-7xl font-extrabold leading-tight text-white mb-6">
                    Trust Delivered
                </h1>
                <p class="text-gray-200 text-xl mb-8 max-w-2xl mx-auto">
                    Thousands rely on PharmaPlus for guaranteed quality, unparalleled speed, and seamless access to every essential health item.
                </p>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <section class="py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                
                <div class="order-2 md:order-1">
                    <span class="text-pink-600 font-bold mb-3 block uppercase text-sm tracking-widest">
                        Our Unwavering Focus
                    </span>

                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">
                        Your Health Deserves More
                    </h2>

                    <p class="text-gray-600 mb-4 leading-relaxed">
                        At PharmaPlus, we focus on two uncompromising pillars: <b>Certified Product Integrity</b> and 
                        <b>Flawless Supply Chain Execution</b>. We don’t just deliver products, we deliver assurance.
                    </p>

                    <p class="text-gray-600 leading-relaxed">
                        Our systems are built for scale and speed, ensuring that even during peak demand, your essential items are processed and dispatched within hours. We’re the dependable link between your needs and trusted wellness solutions.
                    </p>
                </div>

                <div class="order-1 md:order-2">
                    <div class="h-[400px] rounded-2xl shadow-xl overflow-hidden relative">
                        <img src="{{ asset('images/homepage/team.jpg') }}" 
                            alt="PharmaPlus Team Working" 
                            class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </section>

        
        <hr class="my-10">
        <section class="py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="order-1 md:order-1">
                    <div class="h-[400px] rounded-2xl shadow-xl overflow-hidden relative bg-blue-100">
                        <img src="{{ asset('images/homepage/vision.jpg') }}" 
                            alt="Future of Access" 
                            class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="order-2 md:order-2">
                    <span class="text-pink-600 font-bold mb-3 block uppercase text-sm tracking-widest">
                        Our Principles
                    </span>

                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">
                        Built With Purpose
                    </h2>

                    <p class="text-gray-600 mb-4 leading-relaxed">
                        We strive to set the national benchmark for digital health retail by ensuring fast access to verified medical and wellness products, making healthier living effortless and accessible.
                    </p>

                    <ul class="mt-6 space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-3 mt-1">&#x2713;</span>
                            <p class="font-semibold">Precision Logistics: Fast and reliable delivery, every time.</p>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-3 mt-1">&#x2713;</span>
                            <p class="font-semibold">Product Integrity: Authenticity and quality you can trust.</p>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-3 mt-1">&#x2713;</span>
                            <p class="font-semibold">Scalable Inventory: Ready for high-volume demand.</p>
                        </li>
                    </ul>
                </div>
                
            </div>
        </section>

        <hr class="my-10">
        <section class="py-16">
            <div class="text-center mb-12">
                <span class="text-pink-600 font-bold mb-3 block uppercase text-sm tracking-widest">Contact & Logistics</span>
                <h2 class="text-4xl font-extrabold text-gray-900">
                    Logistics and Service Schedule
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-8 bg-white rounded-xl shadow-lg border border-gray-100 transition duration-300 transform hover:shadow-2xl hover:scale-[1.01]">
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
                <div class="p-8 bg-white rounded-xl shadow-lg border border-gray-100 transition duration-300 transform hover:shadow-2xl hover:scale-[1.01]">
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

@endsection