@extends('layouts.admin')

@section('title', 'Detail Pengiriman')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">Detail Pengiriman</h4>
            <p class="text-muted mb-0">
                Kode: <strong>{{ $shipment->code ?? 'SH-' . $shipment->id }}</strong>
            </p>
        </div>
        <a href="{{ route('admin.shipments.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
            &larr; Kembali
        </a>
    </div>

    <div class="row g-3">
        {{-- Info utama --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="mb-3">Informasi Pengiriman</h6>

                    <div class="mb-2">
                        <span class="text-muted d-block">Status</span>
                        @php
                            $status = $shipment->status;
                            $badgeClass = match ($status) {
                                'pending'     => 'bg-secondary',
                                'processed'   => 'bg-info',
                                'on_delivery' => 'bg-warning',
                                'delivered'   => 'bg-success',
                                'cancelled'   => 'bg-danger',
                                default       => 'bg-secondary',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </span>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted d-block">Order</span>
                        <span>{{ optional($shipment->order)->code ?? '-' }}</span>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted d-block">Gudang Asal</span>
                        <span>{{ optional($shipment->originWarehouse)->name ?? '-' }}</span>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted d-block">Gudang Tujuan</span>
                        <span>{{ optional($shipment->destinationWarehouse)->name ?? '-' }}</span>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted d-block">Dibuat Pada</span>
                        <span>{{ $shipment->created_at?->format('d M Y H:i') ?? '-' }}</span>
                    </div>

                    <div>
                        <span class="text-muted d-block">Update Terakhir</span>
                        <span>{{ $shipment->updated_at?->format('d M Y H:i') ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Timeline Status --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="mb-3">Timeline Pengiriman</h6>

                    <ul class="list-unstyled">
                        @foreach ($timeline as $step)
                            <li class="d-flex mb-3">
                                <div class="me-3">
                                    <span class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                          style="width: 20px; height: 20px;
                                                 border: 2px solid {{ $step['active'] ? '#1053D4' : '#d1d5db' }};
                                                 background: {{ $step['active'] ? '#DEE9FF' : '#fff' }};">
                                    </span>
                                </div>
                                <div>
                                    <div class="fw-semibold">
                                        {{ $step['label'] }}
                                    </div>
                                    <div class="text-muted small">
                                        @if ($step['time'])
                                            {{ \Carbon\Carbon::parse($step['time'])->format('d M Y H:i') }}
                                        @else
                                            <em>Belum tercatat</em>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Optional: progress bar kasar berdasarkan status --}}
                    @php
                        $statusIndex = match ($shipment->status) {
                            'pending'     => 25,
                            'processed'   => 50,
                            'on_delivery' => 75,
                            'delivered'   => 100,
                            default       => 10,
                        };
                    @endphp
                    <div class="mt-4">
                        <div class="text-muted small mb-1">Progress Pengiriman</div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" role="progressbar"
                                 style="width: {{ $statusIndex }}%;"
                                 aria-valuenow="{{ $statusIndex }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
