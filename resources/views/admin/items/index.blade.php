@extends('layouts.admin')

@section('title', 'Items')

@section('content')

<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm mt-4 rounded-3">
        <div class="card-body p-4">

            {{-- Header + Search + Button --}}
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between gap-3 header-actions">
                <h2 class="fw-bold text-dark mb-0">Item Management</h2>

                {{-- Search bar --}}
                <form method="GET"
                      action="{{ route('admin.items.index') }}"
                      class="flex-grow-1 order-3 order-lg-2 w-100">
                    <div class="search-wrapper">
                        <span class="search-icon">
                            🔍
                        </span>
                        <input
                            type="text"
                            name="search"
                            class="search-input"
                            placeholder="Search items by name, category, or manufacturer..."
                            value="{{ request('search') }}">
                    </div>
                </form>

                {{-- Add button --}}
                <a href="{{ route('admin.items.create') }}"
                    class="btn btn-primary rounded-pill px-4 shadow-sm order-2 order-lg-3">
                        <span class="fw-bold me-1">+</span> Add New Item
                </a>
            </div>

            {{-- Tabel --}}
            <div class="table-responsive rounded-2 border">
                <table class="table pharma-table align-middle mb-0 w-100">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3 text-uppercase text-secondary" style="width: 5%;">#</th>
                            <th class="text-uppercase text-secondary" style="width: 30%; min-width: 250px;">Item Details</th>
                            <th class="text-uppercase text-secondary">Category</th>
                            <th class="text-uppercase text-secondary">Spec</th>
                            <th class="text-uppercase text-secondary">Price</th>
                            <th class="text-uppercase text-secondary">Stock</th>
                            <th class="pe-1 text-uppercase text-secondary text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            @php
                                $stock  = optional($item->inventory)->stock ?? 0;
                                // $expiry = optional($item->inventory)->expiry_date;
                            @endphp

                            <tr>
                                {{-- Nomor urut --}}
                                <td class="ps-3 text-muted fw-light">
                                    {{ $loop->iteration + $items->firstItem() - 1 }}
                                </td>

                                {{-- Item Details --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark item-name">{{ $item->name }}</span>
                                            <span class="small text-muted">
                                                By {{ $item->manufacturer ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- Category & Indication --}}
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-medium text-dark">{{ $item->category ?? '-' }}</span>
                                        <span class="small text-muted text-truncate" style="max-width: 150px;">
                                            {{ $item->indication ?? '' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Dosage & Strength --}}
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ $item->dosage_form ?? '-' }}
                                    </span>
                                    <div class="small text-muted mt-1">
                                        {{ $item->strength ?? '-' }}
                                    </div>
                                </td>

                                {{-- Price --}}
                                <td class="fw-medium text-dark">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>

                                {{-- Stock + Expiry --}}
                                <td>
                                    @if ($stock <= 10)
                                        <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                                            Low: {{ $stock }}
                                        </span>
                                    @elseif ($stock <= 30)
                                        <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2">
                                            Med: {{ $stock }}
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                            Safe: {{ $stock }}
                                        </span>
                                    @endif

                                    {{-- @if ($expiry)
                                        <div class="small text-muted mt-1" style="font-size: 0.75rem;">
                                            Exp: {{ \Carbon\Carbon::parse($expiry)->format('d M Y') }}
                                        </div>
                                    @endif --}}
                                </td>

                               {{-- Action --}}

                        <td class="pe-3 text-end">
                             <div class="action-buttons d-flex justify-content-center flex-wrap gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.items.edit', $item->id) }}"
                                class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1 action-btn-edit">
                                    Edit
                                </a>

                                {{-- Tombol Delete (pakai form DELETE) --}}
                                <form action="{{ route('admin.items.destroy', $item->id) }}"
                                    method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger rounded-pill px-3 action-btn-delete"
                                            onclick="return confirm('Are you sure you want to delete this item?');">
                                        Delete
                                    </button>
                                </form>
                        </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="mb-2" style="font-size: 2rem; opacity: 0.3;">📂</div>
                                        <span>No items found in the inventory.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer & Pagination --}}
            <div class="mt-4 pt-2">
                <div class="d-flex justify-content-center mb-2 pharma-pagination">
                    {{ $items->links('pagination::bootstrap-4') }}
                </div>
                <div class="text-center text-muted small">
                    Showing <strong>{{ $items->firstItem() ?? 0 }}</strong>
                    to <strong>{{ $items->lastItem() ?? 0 }}</strong>
                    of <strong>{{ $items->total() }}</strong> results
                    @if(request('search'))
                        for "<strong>{{ request('search') }}</strong>"
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- CSS --}}
<style>
    .header-actions {
        margin-bottom: 1.5rem;
    }


    .card { font-family: 'Inter', system-ui, sans-serif; }
    .bg-light { background-color: #f8f9fa !important; }

    /* Search bar */
    .search-wrapper {
        position: relative;
        max-width: 480px;
        margin-left: auto;
        margin-right: auto;
    }
    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.9rem;
        opacity: 0.6;
    }
    .search-input {
        width: 100%;
        border-radius: 999px;
        border: 1px solid #e2e8f0;
        padding: 8px 14px 8px 32px;
        font-size: 0.85rem;
        outline: none;
        transition: 0.15s;
    }
    .search-input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 2px rgba(13,110,253,.15);
    }

    /* Button action */

    .action-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .action-btn-edit{
        background-color: #0d6efd;
        font-size: 0.8rem;
        color: #ffffff;
    }
    .action-btn-delete {
        font-size: 0.8rem;
        background-color: #dc3545;
        color: #ffffff;
    }



    /* Tabel */
    .pharma-table { width: 100%; }
    .pharma-table thead th {
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 9px;
        border-bottom: 1px solid #e9ecef;
        background: #DEE9FF;
    }
    .pharma-table tbody td {
        font-size: 0.875rem;
        padding: 1rem;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: middle;

    }
    .pharma-table tbody tr:hover { background-color: #DEE9FF; }

    /* Hover untuk tombol action */
    .hover-shadow:hover {
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        background-color: #ffffff;
        border-color: #0d6efd !important;
        color: #0d6efd !important;
    }

    /* Pagination */
    .pharma-pagination .pagination {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-bottom: 0;
        padding-left: 0;
    }
    .pharma-pagination .page-item { list-style: none !important; }
    .pharma-pagination .page-link {
        border-radius: 50% !important;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        color: #6c757d;
        font-size: 0.8rem;
        background: transparent;
    }
    .pharma-pagination .page-link:hover {
        background-color: #f1f3f5;
        color: #0d6efd;
    }
    .pharma-pagination .page-item.active .page-link {
        background-color: #0d6efd;
        color: white;
        box-shadow: 0 4px 6px rgba(13,110,253,0.2);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .pharma-table thead th[style*="width"] {
            width: auto !important;
            min-width: auto !important;
        }
        .item-name { white-space: normal; font-size: 0.9rem; }

        /* di mobile, sembunyiin angka page lain, sisakan prev/current/next */
        .pharma-pagination .page-item:not(:first-child):not(:last-child):not(.active) {
            display: none;
        }

        .search-wrapper {
            max-width: 100%;
        }
    }
</style>

@endsection
