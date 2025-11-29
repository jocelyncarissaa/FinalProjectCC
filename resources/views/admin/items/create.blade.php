@extends('layouts.admin')

@section('title', 'Add New Item')

@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="edit-card shadow-sm">
                <div class="edit-card-body">

                    {{-- Header atas --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="{{ route('admin.items.index') }}"
                           class="btn btn-link text-muted text-decoration-none small d-none d-md-inline me-4">
                            ← Back to Items
                        </a>

                        <div>
                            <h2 class="fw-bold header-title">Add New Item</h2>
                            <div class="text-muted small">
                                Create a new medicine record for your warehouse inventory.
                            </div>
                        </div>


                    </div>

                    {{-- Form Create --}}
                    <form method="POST" action="{{ route('admin.items.store') }}">
                        @csrf

                        {{-- SECTION: BASIC DETAILS --}}
                        <div class="form-section mb-4">
                            <div class="section-title ">BASIC DETAILS</div>

                            <div class="row g-3 mt-1">
                                {{-- Item Name --}}
                                <div class="col-md-8">
                                    <label class="field-label">Item Name <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        class="field-input @error('name') is-invalid @enderror"
                                        placeholder="Ex: Paracetamol 500 mg">
                                    @error('name')
                                        <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="help-text">This is the name that will appear in the item list.</div>
                                </div>

                                {{-- Price --}}
                                <div class="col-md-4">
                                    <label class="field-label">Price (Rp)</label>
                                    <input
                                        type="number"
                                        name="price"
                                        value="{{ old('price') }}"
                                        class="field-input @error('price') is-invalid @enderror"
                                        placeholder="15000">
                                    @error('price')
                                        <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="help-text">Numeric value, without separators.</div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: MEDICINE SPECIFICATION --}}
                        <div class="form-section mb-4">
                            <div class="section-title">MEDICINE SPECIFICATION</div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label class="field-label">Category</label>
                                    <input
                                        type="text"
                                        name="category"
                                        value="{{ old('category') }}"
                                        class="field-input"
                                        placeholder="Analgesic / Antibiotic">
                                </div>

                                <div class="col-md-6">
                                    <label class="field-label">Manufacturer</label>
                                    <input
                                        type="text"
                                        name="manufacturer"
                                        value="{{ old('manufacturer') }}"
                                        class="field-input"
                                        placeholder="PT. Kimia Farma">
                                </div>

                                <div class="col-md-6">
                                    <label class="field-label">Dosage Form</label>
                                    <input
                                        type="text"
                                        name="dosage_form"
                                        value="{{ old('dosage_form') }}"
                                        class="field-input"
                                        placeholder="Tablet / Syrup / Capsule">
                                </div>

                                <div class="col-md-6">
                                    <label class="field-label">Strength</label>
                                    <input
                                        type="text"
                                        name="strength"
                                        value="{{ old('strength') }}"
                                        class="field-input"
                                        placeholder="500 mg">
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: ADDITIONAL INFORMATION --}}
                        <div class="form-section mb-4">
                            <div class="section-title">ADDITIONAL INFORMATION</div>

                            <div class="row g-3 mt-1">
                                <div class="col-12">
                                    <label class="field-label">Indication</label>
                                    <textarea
                                        name="indication"
                                        rows="3"
                                        class="field-input textarea-field"
                                        placeholder="Used for fever, mild to moderate pain, etc.">{{ old('indication') }}</textarea>
                                </div>

                                <div class="col-12">
                                    <label class="field-label">Image Path (optional)</label>
                                    <input
                                        type="text"
                                        name="image_path"
                                        value="{{ old('image_path') }}"
                                        class="field-input"
                                        placeholder="e.g. images/paracetamol.png">
                                    <div class="help-text">You can store a relative image URL or leave this field empty.</div>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER BUTTONS --}}
                        <div class="form-footer d-flex flex-column flex-md-row justify-content-between align-items-md-center pt-3 border-top">
                            <a href="{{ route('admin.items.index') }}"
                               class="btn btn-light btn-outline rounded-pill px-4 mb-2 mb-md-0">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="btn btn-success-next rounded-pill px-4">
                                Create Item
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Card wrapper mirip UI contoh */

    .text-muted {
        margin-bottom: 0.7rem; /* bisa 0.75 atau 1rem */
    }

    .edit-card {
        border: none;
        border-radius: 18px;
        background: #DEE9FF;
    }

    .edit-card-body {
        padding: 2rem 2.5rem;
    }

    .form-section + .form-section {
        margin-top: 1.5rem;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 900;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #9ca3af;
    }

    .field-label {
        font-size: 1rem;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 0.25rem;
        text-transform: none;
    }

    .field-input {
        width: 100%;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        padding: 0.65rem 0.9rem;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s, background-color 0.15s;
        background-color: #fcfcfd;
    }

    .field-input:focus {
        border-color: #1053D4;
        box-shadow: 0 0 0 2px rgba(26, 188, 156, 0.15);
        background-color: #ffffff;
    }

    .textarea-field {
        min-height: 96px;
        resize: vertical;
    }

    .help-text {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.2rem;
    }

    .btn-success-next, .btn-link  {
        background-color: #1053D4;
        border-color: #1053D4;
        color: #ffffff;
        border-radius: 999px;
    }

    .btn-success-next:hover  {
        background-color: #448AD5;
        border-color: #448AD5;
        color: #ffffff;
    }
    .form-section .row > div {
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .edit-card-body {
            padding: 1.5rem 1.25rem;
        }
    }
</style>

@endsection
