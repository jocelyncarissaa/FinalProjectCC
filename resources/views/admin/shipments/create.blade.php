@extends('layouts.admin')

@section('content')
<style>
    .page-wrapper {
        padding: 24px;
    }

    .card-soft {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 35px rgba(15, 23, 42, 0.08);
        padding: 24px;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .page-subtitle {
        color: var(--text-muted);
        font-size: 14px;
        margin-bottom: 24px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        color: var(--text-dark);
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        font-size: 14px;
        background: #ffffff;
    }

    .btn-primary-soft {
        background: var(--primary);
        border: none;
        padding: 10px 18px;
        font-size: 14px;
        border-radius: 12px;
        font-weight: 600;
        color: #ffffff;
        cursor: pointer;
    }

    .btn-secondary-soft {
        background: #e5e7eb;
        border: none;
        padding: 10px 18px;
        font-size: 14px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .item-row {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
    }

    .item-row input {
        border-radius: 10px;
    }

    .btn-add-row {
        background: var(--primary-soft);
        color: var(--primary);
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid var(--primary);
    }

    .btn-remove-row {
        background: #fee2e2;
        color: #dc2626;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
        cursor: pointer;
        border: 1px solid #fca5a5;
    }
</style>

<div class="page-wrapper">

    {{-- Judul --}}
    <div class="page-title">Create New Shipment</div>
    <div class="page-subtitle">
        Tambahkan data pengiriman baru dan list obat yang akan dikirim.
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.shipments.store') }}" method="POST">
        @csrf

        <div class="card-soft">

            {{-- Destination --}}
            <div class="mb-3">
                <label class="form-label">Destination Name</label>
                <input type="text" name="destination_name" class="form-control" placeholder="Nama tujuan" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Destination Address</label>
                <input type="text" name="destination_address" class="form-control" placeholder="Alamat tujuan" required>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label">Shipment Status</label>
                <select name="status" class="form-control">
                    <option value="pending">Pending</option>
                    <option value="delivered">Delivered</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
        </div>

        {{-- Items --}}
        <div class="card-soft">
            <div style="font-size: 18px; font-weight: 700; margin-bottom: 12px;">
                Obat yang Dikirim
            </div>

            <div id="item-list">
                <div class="item-row">
                    <input type="text" name="items[0][medicine_name]" class="form-control" placeholder="Nama Obat" required>
                    <input type="number" name="items[0][quantity]" class="form-control" placeholder="Qty" required>

                    <button type="button" class="btn-remove-row" onclick="removeRow(this)">Remove</button>
                </div>
            </div>

            <button type="button" class="btn-add-row mt-2" onclick="addRow()">+ Tambah Obat</button>
        </div>

        {{-- Actions --}}
        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn-primary-soft">
                Save Shipment
            </button>

            <a href="{{ route('admin.shipments.index') }}" class="btn-secondary-soft">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
let itemIndex = 1;

function addRow() {
    const list = document.getElementById('item-list');

    const row = document.createElement('div');
    row.classList.add('item-row');

    row.innerHTML = `
        <input type="text" name="items[${itemIndex}][medicine_name]" class="form-control" placeholder="Nama Obat" required>
        <input type="number" name="items[${itemIndex}][quantity]" class="form-control" placeholder="Qty" required>
        <button type="button" class="btn-remove-row" onclick="removeRow(this)">Remove</button>
    `;

    list.appendChild(row);
    itemIndex++;
}

function removeRow(button) {
    button.parentElement.remove();
}
</script>

@endsection
