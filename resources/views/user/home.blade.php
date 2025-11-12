@extends('user.layouts.app')

@section('content')

    <div class="bg-hero-bg pb-24">
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

        <section class="mb-16 -mt-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-hero-bg p-8 rounded-xl shadow-lg flex items-center justify-between">
                    <div>
                        <span class="text-pink-600 font-bold mb-2 block">Big Sale</span>
                        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Get an Extra <br><span class="text-indigo-600">50% Off</span></h2>
                        <p class="text-gray-500 max-w-xs">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                    </div>
                    <div class="w-2/5 h-40 bg-gray-800 rounded-lg"></div>
                </div>
    
                <div class="bg-blue-700 p-8 rounded-xl shadow-lg flex items-center justify-between">
                    <div>
                        <span class="text-white font-semibold mb-2 block">Holiday Savings</span>
                        <h2 class="text-6xl font-extrabold text-white mb-4">Up to 40%</h2>
                        <button class="bg-white text-blue-700 font-bold py-3 px-6 rounded-full hover:bg-gray-100 transition duration-200">Shop Now</button>
                    </div>
                    <div class="w-2/5 h-40 bg-gray-800 rounded-lg opacity-70"></div>
                </div>
            </div>
        </section>
    
        <section class="mb-16">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <span class="text-pink-600 font-bold mb-1 block">Featured</span>
                    <h2 class="text-3xl font-extrabold text-gray-900">Featured Pharmacy Essentials</h2>
                    <p class="text-gray-500 max-w-lg">Nec leo amet suscipit nulla. Nullam vitae sit tempus diam.</p>
                </div>
                <a href="#" class="text-blue-600 font-semibold hover:text-blue-800 transition duration-150 hidden sm:block">All Products &rarr;</a>
            </div>
    
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                
                <div class="bg-white p-4 rounded-xl shadow-lg">
                    <div class="bg-gray-900 h-48 rounded-lg mb-4 relative flex items-center justify-center">
                        <button class="absolute top-3 right-3 bg-blue-600/70 p-2 rounded-full text-white hover:bg-blue-700 transition duration-150">&rarr;</button>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-900">Acetaminophen Pills</h3>
                    <p class="text-gray-500 text-sm">Pain Reliever</p>
                    <div class="mt-2">
                        <span class="text-gray-400 line-through mr-2">$16.00</span>
                        <span class="text-red-600 font-bold">$12.50</span>
                    </div>
                </div>
    
                <div class="bg-white p-4 rounded-xl shadow-lg">
                    <div class="bg-gray-900 h-48 rounded-lg mb-4"></div>
                    <h3 class="font-semibold text-lg text-gray-900">Throat Lozenges Syrup</h3>
                    <p class="text-gray-500 text-sm">Cough & Cold</p>
                    <div class="mt-2">
                        <span class="text-gray-400 line-through mr-2">$16.00</span>
                        <span class="text-red-600 font-bold">$12.00</span>
                    </div>
                </div>
    
                <div class="bg-white p-4 rounded-xl shadow-lg">
                    <div class="bg-gray-900 h-48 rounded-lg mb-4"></div>
                    <h3 class="font-semibold text-lg text-gray-900">Multivitamin B6+</h3>
                    <p class="text-gray-500 text-sm">Vitamins</p>
                    <div class="mt-2">
                        <span class="text-gray-400 line-through mr-2">$18.99</span>
                        <span class="text-red-600 font-bold">$12.00</span>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-xl shadow-lg">
                    <div class="bg-gray-900 h-48 rounded-lg mb-4"></div>
                    <h3 class="font-semibold text-lg text-gray-900">Dental Floss</h3>
                    <p class="text-gray-500 text-sm">Oral Care</p>
                    <div class="mt-2">
                        <span class="text-red-600 font-bold">$5.50</span>
                    </div>
                </div>
    
            </div>
        </section>
    
        <section class="mb-16">
            <h2 class="sr-only">Product Categories</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="bg-white p-6 rounded-xl shadow-lg relative h-64 overflow-hidden">
                    <div class="absolute inset-0 bg-gray-900 opacity-80 rounded-xl"></div>
                    <div class="relative z-10 text-white">
                        <h3 class="text-2xl font-bold mb-2">Pain Relievers</h3>
                        <p class="text-gray-300 max-w-sm">Libero diam auctor tristique hendrerit eu in vel elit.</p>
                        <a href="#" class="text-blue-400 font-semibold mt-4 block hover:text-blue-200">Explore Category &rarr;</a>
                    </div>
                    <div class="absolute top-4 right-4 space-y-2">
                        <div class="w-3 h-3 bg-white rounded-full"></div>
                        <div class="w-3 h-3 bg-white/50 rounded-full"></div>
                    </div>
                </div>
    
                <div class="bg-white p-6 rounded-xl shadow-lg relative h-64 overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold mb-2 text-gray-900">Allergy Medications</h3>
                        <p class="text-gray-600 max-w-sm">Libero diam auctor tristique hendrerit eu in vel elit.</p>
                        <a href="#" class="text-blue-600 font-semibold mt-4 block hover:text-blue-800">Explore Category &rarr;</a>
                    </div>
                    <div class="absolute top-0 right-0 w-1/2 h-full bg-gray-800 rounded-l-lg"></div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-lg relative h-64 overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold mb-2 text-gray-900">First Aid Supply</h3>
                        <p class="text-gray-600 max-w-sm">Libero diam auctor tristique hendrerit eu in vel elit.</p>
                        <a href="#" class="text-blue-600 font-semibold mt-4 block hover:text-blue-800">Explore Category &rarr;</a>
                    </div>
                    <div class="absolute top-0 right-0 w-1/2 h-full bg-gray-800 rounded-l-lg"></div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-lg relative h-64 overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold mb-2 text-gray-900">Dental Care</h3>
                        <p class="text-gray-600 max-w-sm">Libero diam auctor tristique hendrerit eu in vel elit.</p>
                        <a href="#" class="text-blue-600 font-semibold mt-4 block hover:text-blue-800">Explore Category &rarr;</a>
                    </div>
                    <div class="absolute top-0 right-0 w-1/2 h-full bg-gray-800 rounded-l-lg"></div>
                </div>
    
            </div>
        </section>
    
        <section class="pb-16 pt-8">
            <div class="flex flex-col md:flex-row gap-12">
                
                <div class="w-full md:w-1/2">
                    <span class="text-pink-600 font-bold mb-1 block">Why Us</span>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Our Commitment to Quality</h2>
                    
                    <div class="space-y-6">
                        
                        <div class="flex items-start">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-lg mr-4">🛒</div>
                            <div>
                                <h4 class="font-bold text-gray-900">Wide Product Range</h4>
                                <p class="text-gray-600 text-sm max-w-sm">Libero diam auctor tristique hendrerit eu in vel elit.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-lg mr-4">🛡️</div>
                            <div>
                                <h4 class="font-bold text-gray-900">Quality Assurance</h4>
                                <p class="text-gray-600 text-sm max-w-sm">Libero diam auctor tristique hendrerit eu in vel elit.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-lg mr-4">🌱</div>
                            <div>
                                <h4 class="font-bold text-gray-900">Eco-Friendly Practices</h4>
                                <p class="text-gray-600 text-sm max-w-sm">Libero diam auctor tristique hendrerit eu in vel elit.</p>
                            </div>
                        </div>
    
                    </div>
                </div>
    
                <div class="w-full md:w-1/2">
                    <div class="bg-gray-800 h-[450px] rounded-[30px] shadow-2xl relative">
                        </div>
                </div>
    
            </div>
        </section>
    </div>

@endsection