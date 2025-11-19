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
                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                           style="text-decoration: none; background: #fff; border: 1px solid #D1D5DB; color: #374151; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.8rem; font-weight: 500; transition: all 0.2s;">
                           View Details
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
    tr:hover {
        background-color: #F9FAFB;
    }
    tr:hover a {
        border-color: var(--primary) !important;
        color: var(--primary) !important;
        background-color: var(--primary-soft) !important;
    }
</style>
@endsection