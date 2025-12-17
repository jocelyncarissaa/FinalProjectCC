@extends('layouts.admin')

@section('content')
<div class="page-header">
    <h1 class="page-title">Order Management</h1>
    <p class="page-subtitle">Monitor and process incoming customer orders.</p>
</div>

<div class="panel" style="margin-top: 1.5rem; overflow: hidden; padding: 0;">
    
    <div class="panel-header" style="padding: 1.5rem; border-bottom: 1px solid #F3F4F6; display: flex; justify-content: space-between; align-items: center;">
        <span class="panel-title">Recent Orders</span>
        
        <form action="{{ route('admin.orders.index') }}" method="GET">
            <div style="position: relative; display: inline-block;">
                <select name="status" onchange="this.form.submit()" 
                        style="appearance: none; -webkit-appearance: none; padding: 0.6rem 2.5rem 0.6rem 1rem; 
                               border: 1px solid #E5E7EB; border-radius: 8px; background: white; color: #374151; 
                               font-size: 0.85rem; font-weight: 500; cursor: pointer; outline: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <!-- <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option> -->
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <div style="position: absolute; right: 0.8rem; top: 50%; transform: translateY(-50%); pointer-events: none; color: #6B7280; font-size: 0.7rem;">
                    ▼
                </div>
            </div>
        </form>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
            <thead style="background-color: #F9FAFB; color: #6B7280; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">
                <tr>
                    <th style="padding: 1rem 1.5rem; text-align: left;">Order ID</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; width: 30%;">Customer</th>
                    <th style="padding: 1rem 1.5rem; text-align: right;">Total Amount</th>
                    <th style="padding: 1rem 1.5rem; text-align: center;">Status</th>
                    <th style="padding: 1rem 1.5rem; text-align: left;">Date</th>
                    <th style="padding: 1rem 1.5rem; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr style="border-bottom: 1px solid #F3F4F6; transition: background 0.2s;">
                    <td style="padding: 1rem 1.5rem; font-weight: 600; color: #111827;">
                        #{{ $order->id }}
                    </td>
                    
                    <td style="padding: 1rem 1.5rem;">
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-weight: 600; color: #111827;">
                                {{ $order->user->name ?? 'Guest' }}
                            </span>
                            <span style="font-size: 0.8rem; color: #9CA3AF;">
                                {{ $order->user->email ?? '-' }}
                            </span>
                        </div>
                    </td>

                    <td style="padding: 1rem 1.5rem; text-align: right; font-family: monospace; font-size: 0.95rem; font-weight: 600; color: #111827;">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </td>

                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        @php
                            $statusColor = match($order->status) {
                                'paid' => 'background: #D1FAE5; color: #065F46;',      // Green
                                'pending' => 'background: #FEF3C7; color: #92400E;',   // Yellow/Orange
                                'shipped' => 'background: #DBEAFE; color: #1E40AF;',   // Blue
                                'cancelled' => 'background: #FEE2E2; color: #991B1B;', // Red
                                // 'completed' => 'background: #E0E7FF; color: #3730A3;', // Indigo
                                default => 'background: #F3F4F6; color: #374151;'      // Gray
                            };
                        @endphp
                        
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-transform: capitalize; {{ $statusColor }}">
                            {{ $order->status }}
                        </span>
                    </td>

                    <td style="padding: 1rem 1.5rem; color: #6B7280;">
                        {{ $order->created_at->format('d M Y') }}
                        <div style="font-size: 0.75rem; color: #9CA3AF;">
                            {{ $order->created_at->format('H:i') }}
                        </div>
                    </td>

                    <td style="padding: 1rem 1.5rem; text-align: center;">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-action">
                            <span>View Details</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 3rem; text-align: center; color: #9CA3AF;">
                        No orders found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="padding: 1rem 1.5rem; border-top: 1px solid #E5E7EB;">
        {{ $orders->links() }}
    </div>
</div>

<style>
    /* Efek hover pada baris tabel agar lebih interaktif */
    tr:hover {
        background-color: #F9FAFB;
    }

    /* Style untuk Tombol Action */
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        
        background-color: #ffffff;
        border: 1px solid #D1D5DB;
        color: #374151;
        
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
        white-space: nowrap; /* Mencegah teks turun ke baris baru */
    }

    /* Efek Hover Tombol */
    .btn-action:hover {
        border-color: #1364FF;
        background-color: #1364FF;
        color: #ffffff;
        transform: translateY(-1px); /* Efek tombol sedikit naik */
        box-shadow: 0 4px 6px -1px rgba(19, 100, 255, 0.2); /* Bayangan biru halus */
    }

    /* Animasi panah kecil saat di-hover */
    .btn-action:hover svg {
        transform: translateX(2px);
    }
</style>
@endsection