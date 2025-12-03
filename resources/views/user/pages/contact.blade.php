@extends('user.layouts.app')

@section('content')
    <div class="pt-24 pb-16 bg-cover bg-center bg-no-repeat relative" 
        style="background-image: url('{{ asset('images/homepage/contact.jpg') }}');">
        <div class="absolute inset-0 bg-white/60 backdrop-blur-sm"></div> 
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <p class="text-pink-600 font-semibold mb-3 tracking-widest uppercase text-sm">
                    Get in Touch
                </p>
                <h1 class="text-6xl lg:text-7xl font-extrabold leading-tight text-gray-900 mb-6">
                    Contact Us
                </h1>
                <p class="text-gray-700 text-xl mb-8">
                    We're here to provide seamless assistance and support for all your needs.
                </p>
            </div>
        </div>
    </div>

    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <section class="py-16 -mt-32 relative z-20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-white rounded-2xl shadow-2xl border border-gray-100 h-full transition duration-300 transform hover:shadow-xl hover:scale-[1.01]">
                    <div class="flex items-start mb-4">
                        <div class="p-3 bg-blue-600 rounded-lg text-white mr-4">🏠</div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Head Office Address</h3>
                            <p class="text-gray-500 text-sm">PharmaPlus Surabaya</p>
                        </div>
                    </div>
                    <p class="text-gray-700 leading-relaxed pl-14">
                        Ruko Plaza Segi 8, Rungkut Madya No. 42, Surabaya, Jawa Timur, Indonesia.
                    </p>
                    <a href="#" class="mt-4 inline-block text-pink-600 font-semibold hover:text-blue-800 pl-14">
                        View on Map &rarr;
                    </a>
                </div>

                <div class="p-6 bg-white rounded-2xl shadow-2xl border border-gray-100 h-full transition duration-300 transform hover:shadow-xl hover:scale-[1.01]">
                    <div class="flex items-start mb-4">
                        <div class="p-3 bg-blue-600 rounded-lg text-white mr-4">📞</div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Phone & WhatsApp</h3>
                            <p class="text-gray-500 text-sm">Customer Support Line</p>
                        </div>
                    </div>
                    <div class="space-y-2 pl-14">
                        <p class="text-lg font-semibold text-gray-700">
                            Call: <a href="tel:+6285464442222" class="text-blue-600 hover:underline">(031) 8542222</a>
                        </p>
                        <p class="text-lg font-semibold text-gray-700">
                            WhatsApp: <a href="https://wa.me/6285464442222" target="_blank" class="text-blue-600 hover:underline">+62 854 6444 2222</a>
                        </p>
                    </div>
                </div>

                <div class="p-6 bg-white rounded-2xl shadow-2xl border border-gray-100 h-full transition duration-300 transform hover:shadow-xl hover:scale-[1.01]">
                    <div class="flex items-start mb-4">
                        <div class="p-3 bg-blue-600 rounded-lg text-white mr-4">📧</div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">General Email</h3>
                            <p class="text-gray-500 text-sm">Inquiries & Partnerships</p>
                        </div>
                    </div>
                    <p class="text-lg font-semibold text-gray-700 pl-14">
                        <a href="mailto:info@pharmaplus.com" class="text-blue-600 hover:underline">info@pharmaplus.com</a>
                    </p>
                    <p class="mt-2 text-sm text-gray-500 pl-14">
                        We usually respond within 1 business day.
                    </p>
                </div>
                
            </div>
        </section>

    </div>

@endsection