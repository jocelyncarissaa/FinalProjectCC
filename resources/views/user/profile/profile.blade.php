@extends('user.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        {{-- Alert Sukses --}}
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Alert Error Validation --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded relative">
                <strong class="font-bold">Whoops!</strong>
                <ul class="list-disc ml-5 mt-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8 border border-gray-100 relative">
            <div class="h-32 bg-gradient-to-r from-blue-600 to-[#1364FF]"></div>

            <div class="px-6 sm:px-8 pb-8 relative">
                
                <div class="flex flex-col sm:flex-row items-center sm:items-end -mt-12 mb-6">
                    <div class="relative">
                        <div class="w-28 h-28 bg-white p-1 rounded-full shadow-md">
                            <div class="w-full h-full bg-blue-50 text-[#1364FF] rounded-full flex items-center justify-center text-3xl font-bold uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-2 border-white rounded-full" title="Online"></div>
                    </div>

                    <div class="mt-4 sm:mt-0 sm:ml-6 text-center sm:text-left flex-1">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-500 font-medium">{{ $user->email }}</p>
                    </div>

                    <div class="mt-6 sm:mt-0 flex space-x-3">
                        {{-- Tombol Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-semibold hover:bg-gray-50 transition shadow-sm">
                                Log Out
                            </button>
                        </form>
                        
                        {{-- Tombol Edit Profile (Memicu Modal) --}}
                        <button onclick="toggleModal('editProfileModal')" class="px-4 py-2 bg-[#1364FF] text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition shadow-md flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Edit Profile
                        </button>
                    </div>
                </div>

                <hr class="border-gray-100 mb-6">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-blue-50 rounded-lg text-[#1364FF]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Phone</p>
                            <p class="text-gray-700 font-medium">{{ $user->phone ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-blue-50 rounded-lg text-[#1364FF]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Joined</p>
                            <p class="text-gray-700 font-medium">{{ $user->created_at->format('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-blue-50 rounded-lg text-[#1364FF]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Address</p>
                            <p class="text-gray-700 font-medium line-clamp-2">{{ $user->address ?? 'No address registered' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Order History
                </h2>
                <span class="bg-blue-100 text-[#1364FF] text-xs font-bold px-3 py-1 rounded-full">
                    {{ $orders->count() }} Orders
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 whitespace-nowrap">Order ID</th>
                            <th class="px-6 py-4 whitespace-nowrap">Date</th>
                            <th class="px-6 py-4 whitespace-nowrap">Total Amount</th>
                            <th class="px-6 py-4 whitespace-nowrap">Status</th>
                            <th class="px-6 py-4 text-center whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out group">
                            <td class="px-6 py-4 font-bold text-[#1364FF] group-hover:text-blue-700">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm whitespace-nowrap">
                                {{ $order->created_at->format('d M, Y') }}
                                <span class="text-xs text-gray-400 block">{{ $order->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-orange-100 text-orange-700 border-orange-200',
                                        'paid' => 'bg-cyan-100 text-cyan-700 border-cyan-200',
                                        'shipped' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                        'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                    ];
                                    $class = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase border {{ $class }} inline-flex items-center gap-1">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if(Route::has('profile.order.detail'))
                                    <a href="{{ route('profile.order.detail', $order->id) }}" class="text-sm font-semibold text-gray-500 hover:text-[#1364FF] transition flex items-center justify-center gap-1">
                                        Details
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    </div>
                                    <h3 class="text-gray-900 font-bold text-lg">No Orders Yet</h3>
                                    <p class="text-gray-500 text-sm mb-4">Start shopping to see your orders here.</p>
                                    <a href="{{ route('products') }}" class="px-5 py-2 bg-[#1364FF] text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                        Browse Products
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- ============================== --}}
{{-- MODAL EDIT PROFILE --}}
{{-- ============================== --}}
<div id="editProfileModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="toggleModal('editProfileModal')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Edit Profile Information
                            </h3>
                            <div class="mt-4 space-y-4">
                                
                                {{-- Name --}}
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#1364FF] focus:border-[#1364FF] sm:text-sm">
                                </div>

                                {{-- Email (Read Only) --}}
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-xs text-gray-400">(Cannot be changed)</span></label>
                                    <input type="email" value="{{ $user->email }}" disabled
                                        class="mt-1 block w-full border border-gray-300 bg-gray-100 rounded-md shadow-sm py-2 px-3 text-gray-500 sm:text-sm cursor-not-allowed">
                                </div>

                                {{-- Phone --}}
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. 08123456789"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#1364FF] focus:border-[#1364FF] sm:text-sm">
                                </div>

                                {{-- Address --}}
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                    <textarea name="address" id="address" rows="3" placeholder="Enter your full address"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#1364FF] focus:border-[#1364FF] sm:text-sm">{{ old('address', $user->address) }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#1364FF] text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Save Changes
                    </button>
                    <button type="button" onclick="toggleModal('editProfileModal')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal(modalID) {
        document.getElementById(modalID).classList.toggle("hidden");
    }
</script>
@endsection