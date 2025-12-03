{{-- resources/views/admin/shipments/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<style>
    .shipment-page {
        padding: 24px;
    }

    .shipment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .shipment-header-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .shipment-header-subtitle {
        font-size: 14px;
        color: var(--text-muted);
    }

    /* Stepper Status */
    .shipment-steps {
        display: flex;
        gap: 16px;
        background: #ffffff;
        border-radius: 999px;
        padding: 12px 20px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
        margin-bottom: 24px;
        align-items: center;
        flex-wrap: wrap;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 18px;
        border-radius: 999px;
        font-size: 14px;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }

    .step-item span.step-index {
        width: 26px;
        height: 26px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        background: var(--primary-soft);
        color: var(--primary);
        font-size: 13px;
    }

    .step-item-active {
        background: var(--primary);
        color: #ffffff;
        border-color: var(--primary);
    }

    .step-item-active span.step-index {
        background: #ffffff;
        color: var(--primary);
    }

    .step-label {
        font-weight: 600;
    }

    /* Main layout */
    .shipment-content {
        display: grid;
        grid-template-columns: minmax(0, 2.3fr) minmax(0, 1.3fr);
        gap: 24px;
    }

    @media (max-width: 992px) {
        .shipment-content {
            grid-template-columns: 1fr;
        }
    }

    .card-soft {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 35px rgba(15, 23, 42, 0.08);
        padding: 20px 24px;
    }

    /* Left: Shipment details & list */
    .banner-status {
        display: flex;
        gap: 16px;
        align-items: flex-start;
        padding: 16px 18px;
        border-radius: 16px;
        background: #e7f7ef;
        border: 1px solid #b6e6cc;
        margin-bottom: 20px;
    }

    .banner-icon {
        width: 32px;
        height: 32px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #22c55e;
        color: #ffffff;
        font-size: 18px;
        flex-shrink: 0;
    }

    .banner-title {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 4px;
        color: #14532d;
    }

    .banner-text {
        font-size: 13px;
        color: #166534;
    }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--text-dark);
    }

    .section-subtitle {
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    .shipment-info-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .shipment-info-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    .info-block-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--text-muted);
        margin-bottom: 4px;
        font-weight: 600;
    }

    .info-block-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .info-block-helper {
        font-size: 12px;
        color: var(--text-muted);
    }

    /* Table items (list obat) */
    .table-wrapper {
        margin-top: 8px;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .table {
        margin-bottom: 0;
        font-size: 13px;
    }

    .table thead {
        background: #f9fafb;
    }

    .table thead th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        border-bottom: 1px solid #e5e7eb;
        padding: 10px 12px;
    }

    .table tbody td {
        padding: 10px 12px;
        vertical-align: middle;
        border-top: 1px solid #f3f4f6;
    }

    .pill-item {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 999px;
        background: var(--primary-soft);
        font-size: 12px;
        margin: 2px 4px 2px 0;
    }

    .pill-item span.qty {
        font-weight: 600;
        color: var(--primary);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-delivered {
        background: #dcfce7;
        color: #166534;
    }

    .status-completed {
        background: #e0f2fe;
        color: #1d4ed8;
    }

    .btn-soft-primary {
        border-radius: 999px;
        padding: 7px 16px;
        font-size: 13px;
        border: none;
        background: var(--primary);
        color: #ffffff;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-soft-primary:hover {
        opacity: 0.95;
    }

    /* Right: summary */
    .summary-block {
        margin-bottom: 16px;
    }

    .summary-label {
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 2px;
    }

    .summary-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .summary-price-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        margin-bottom: 6px;
    }

    .summary-price-label {
        color: var(--text-muted);
    }

    .summary-price-value {
        font-weight: 600;
    }

    .summary-total {
        border-top: 1px dashed #e5e7eb;
        margin-top: 10px;
        padding-top: 10px;
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        font-weight: 700;
        color: #16a34a;
    }

    .summary-footer-note {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 10px;
    }
</style>

<div class="shipment-page">
    {{-- Header --}}
    <div class="shipment-header">
        <div>
            <div class="shipment-header-title">Shipment Management</div>
            <div class="shipment-header-subtitle">
                Pantau proses pengiriman obat: dari Pending, Delivered, sampai Completed.
            </div>
        </div>
        <div>
            {{-- <a href="{{ route('admin.shipments.create') }}" class="btn-soft-primary">
                + New Shipment
            </a> --}}
        </div>
    </div>

    {{-- Status Stepper --}}
    @php
        $currentStatus = request('status', $currentStatus ?? 'pending');
    @endphp

    <div class="shipment-steps">
        <a href="{{ route('admin.shipments.index', ['status' => 'pending']) }}"
           class="step-item {{ $currentStatus === 'pending' ? 'step-item-active' : '' }}">
            <span class="step-index">1</span>
            <div>
                <div class="step-label">Pending</div>
                <div style="font-size: 11px; opacity: .8;">
                    {{ $statusSummary['pending'] ?? 0 }} shipment menunggu diproses
                </div>
            </div>
        </a>

        <a href="{{ route('admin.shipments.index', ['status' => 'delivered']) }}"
           class="step-item {{ $currentStatus === 'delivered' ? 'step-item-active' : '' }}">
            <span class="step-index">2</span>
            <div>
                <div class="step-label">Delivered</div>
                <div style="font-size: 11px; opacity: .8;">
                    {{ $statusSummary['delivered'] ?? 0 }} shipment sudah dikirim
                </div>
            </div>
        </a>

        <a href="{{ route('admin.shipments.index', ['status' => 'completed']) }}"
           class="step-item {{ $currentStatus === 'completed' ? 'step-item-active' : '' }}">
            <span class="step-index">3</span>
            <div>
                <div class="step-label">Completed</div>
                <div style="font-size: 11px; opacity: .8;">
                    {{ $statusSummary['completed'] ?? 0 }} shipment selesai
                </div>
            </div>
        </a>
    </div>

    {{-- Main content --}}
    <div class="shipment-content">
        {{-- LEFT: detail shipment + list obat --}}
        <div class="card-soft">
            {{-- Banner status --}}
            <div class="banner-status">
                <div class="banner-icon">
                    ✓
                </div>
                <div>
                    <div class="banner-title">
                        @if($currentStatus === 'pending')
                            Shipment dalam status Pending
                        @elseif($currentStatus === 'delivered')
                            Shipment sedang/ sudah Delivered
                        @else
                            Shipment Completed
                        @endif
                    </div>
                    <div class="banner-text">
                        Daftar di bawah menampilkan shipment dengan status
                        <strong>{{ ucfirst($currentStatus) }}</strong> beserta list obat yang sedang diproses.
                    </div>
                </div>
            </div>

            {{-- Info ringkas (optional, ambil dari shipment terpilih / statistik) --}}
            <div class="section-title">Overview</div>
            <div class="shipment-info-grid">
                <div>
                    <div class="info-block-label">Total Shipment</div>
                    <div class="info-block-value">
                        {{ $statusSummary[$currentStatus] ?? 0 }}
                    </div>
                    <div class="info-block-helper">
                        Dalam status {{ ucfirst($currentStatus) }}
                    </div>
                </div>
                <div>
                    <div class="info-block-label">Total Obat diproses</div>
                    <div class="info-block-value">
                        {{ $totalItemsInStatus ?? '-' }}
                    </div>
                    <div class="info-block-helper">
                        Akumulasi semua shipment
                    </div>
                </div>
                <div>
                    <div class="info-block-label">Last Update</div>
                    <div class="info-block-value">
                        {{ $lastUpdatedAt ?? now()->format('d M Y') }}
                    </div>
                    <div class="info-block-helper">
                        Dibaca otomatis dari data
                    </div>
                </div>
            </div>

            {{-- List shipment + list obat --}}
            <div class="section-title">Shipment List</div>
            <div class="section-subtitle">
                Klik detail untuk melihat informasi pengiriman lebih lengkap.
            </div>

            <div class="table-wrapper">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Shipment Code</th>
                            <th>Destination</th>
                            <th>List Obat</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shipments as $shipment)
                            <tr>
                                <td>
                                    <strong>#{{ $shipment->code }}</strong>
                                </td>
                                <td>
                                    {{ $shipment->destination_name ?? '-' }}<br>
                                    <span style="font-size: 11px; color: var(--text-muted);">
                                        {{ $shipment->destination_address ?? '' }}
                                    </span>
                                </td>
                                <td>
                                    @foreach($shipment->items as $item)
                                        <div class="pill-item">
                                            {{ $item->medicine_name }}
                                            <span class="qty">x{{ $item->quantity }}</span>
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    @php
                                        $statusClass = $shipment->status === 'pending'
                                            ? 'status-pending'
                                            : ($shipment->status === 'delivered'
                                                ? 'status-delivered'
                                                : 'status-completed');
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ ucfirst($shipment->status) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $shipment->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.shipments.show', $shipment->id) }}"
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    Belum ada shipment pada status ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination (kalau pakai paginate di controller) --}}
            <div class="mt-3">
                {{ $shipments->links() ?? '' }}
            </div>
        </div>

        {{-- RIGHT: reservation / shipment summary --}}
        <div class="card-soft">
            <div class="section-title">Shipment Summary</div>
            <div class="section-subtitle">
                Ringkasan total pengiriman berdasarkan status terpilih.
            </div>

            <div class="summary-block">
                <div class="summary-label">Status dipilih</div>
                <div class="summary-value">
                    {{ ucfirst($currentStatus) }}
                </div>
            </div>

            <div class="summary-block">
                <div class="summary-label">Total Shipment</div>
                <div class="summary-value">
                    {{ $statusSummary[$currentStatus] ?? 0 }} shipment
                </div>
            </div>

            <div class="summary-block">
                <div class="summary-label">Total Obat</div>
                <div class="summary-value">
                    {{ $totalItemsInStatus ?? '-' }} item
                </div>
            </div>

            <hr>

            {{-- Contoh price summary kalau kamu punya nilai rupiah per shipment --}}
            <div class="section-title" style="font-size: 14px; margin-bottom: 10px;">
                Estimasi Nilai Barang
            </div>

            <div class="summary-price-row">
                <div class="summary-price-label">Total Value (Obat)</div>
                <div class="summary-price-value">
                    Rp {{ number_format($totalValue ?? 0, 0, ',', '.') }}
                </div>
            </div>

            <div class="summary-price-row">
                <div class="summary-price-label">Estimated Shipping Cost</div>
                <div class="summary-price-value">
                    Rp {{ number_format($totalShippingCost ?? 0, 0, ',', '.') }}
                </div>
            </div>

            <div class="summary-total">
                <span>Total</span>
                <span>Rp {{ number_format(($totalValue ?? 0) + ($totalShippingCost ?? 0), 0, ',', '.') }}</span>
            </div>

            <div class="mt-4">
                {{-- <button class="btn-soft-primary w-100">
                    Download Shipment Report
                </button> --}}
            </div>
        </div>
    </div>
</div>
@endsection
