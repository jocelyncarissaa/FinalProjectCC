@extends('layouts.admin')

@section('content')
<div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
    <a href="{{ route('admin.orders.index') }}" class="btn">← Back</a>
    <h1 class="page-title">Order Details #{{ $order->id }}</h1>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">

    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">Items Ordered</span>
        </div>
        <table style="margin-top: 0.5rem;">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $detail)
                <tr>
                    <td>
                        <span style="font-weight: 600; color: var(--primary);">{{ $detail->item->name }}</span>
                    </td>
                    <td>Rp {{ number_format($detail->price_per_unit, 0, ',', '.') }}</td>
                    <td>x {{ $detail->quantity }}</td>
                    <td style="text-align: right; font-weight: 700;">
                        Rp {{ number_format($detail->price_per_unit * $detail->quantity, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; padding: 1rem; font-weight: bold;">Grand Total</td>
                    <td style="text-align: right; padding: 1rem; font-weight: 800; font-size: 1.1rem; color: var(--primary);">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1rem;">
        <div class="panel">
            <div class="panel-header"><span class="panel-title">Customer Info</span></div>
            <div class="panel" style="background-color: #F0F9FF; border: 1px solid #BAE6FD;">
                <div class="panel-header">
                    <span class="panel-title" style="color: #0369A1;">Update Status</span>
                </div>
                <div class="panel-body" style="display: block;">
                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-size: 0.85rem; font-weight: 600; color: #0C4A6E;">
                                Current Status: 
                                <span style="text-transform: uppercase; color: var(--primary);">{{ $order->status }}</span>
                            </label>
                            
                            <select name="status" style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #7DD3FC; background: white; outline: none;">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <!-- <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option> -->
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
            <div class="panel-body" style="display: block;">
                <div style="margin-bottom: 0.5rem;">
                    <div style="color: var(--text-muted); font-size: 0.8rem;">Name</div>
                    <div style="font-weight: 600;">{{ $order->user->name ?? 'Guest' }}</div>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <div style="color: var(--text-muted); font-size: 0.8rem;">Email</div>
                    <div>{{ $order->user->email ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header"><span class="panel-title">Shipping Address</span></div>
            <div class="panel-body" style="display: block; line-height: 1.5; color: var(--text-muted);">
                {{ $order->shipping_address }}
            </div>
        </div>
    </div>

</div>
@endsection