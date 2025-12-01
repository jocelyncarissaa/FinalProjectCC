<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    // List semua pengiriman
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $shipments = Shipment::where('status', $status)
            ->latest()
            ->paginate(10);

        $statusSummary = [
            'pending'   => Shipment::where('status', 'pending')->count(),
            'delivered' => Shipment::where('status', 'delivered')->count(),
            'completed' => Shipment::where('status', 'completed')->count(),
        ];

        // sementara: belum hitung totalItemsInStatus kalau relasi items belum jadi
        $totalItemsInStatus = null;

        return view('admin.shipments.index', compact(
            'shipments',
            'statusSummary',
            'status',
            'totalItemsInStatus'
        ))->with('currentStatus', $status);
    }

    // ✅ TAMPILKAN FORM CREATE
    public function create()
    {
        return view('admin.shipments.create');
    }

    // ✅ SIMPAN DATA BARU
    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'destination_name'    => 'required|string|max:255',
            'destination_address' => 'required|string|max:500',
            'status'              => 'required|in:pending,delivered,completed',

            // optional, nanti dipakai kalau tabel detail obat sudah siap
            'items'                       => 'nullable|array',
            'items.*.medicine_name'       => 'nullable|string|max:255',
            'items.*.quantity'            => 'nullable|integer|min:1',
        ]);

        // Buat kode shipment sederhana
        $code = 'SHP-' . now()->format('ymdHis');

        // Simpan shipment ke database
        $shipment = Shipment::create([
            'code'               => $code,
            'destination_name'   => $data['destination_name'],
            'destination_address'=> $data['destination_address'],
            'status'             => $data['status'],
        ]);

        // TODO: simpan detail obat ke tabel lain (misal: shipment_items)
        // untuk sekarang, biarkan dulu supaya flow form-nya jalan

        return redirect()
            ->route('admin.shipments.show', $shipment->id)
            ->with('success', 'Shipment berhasil dibuat.');
    }

    // Detail satu pengiriman
    public function show(Shipment $shipment)
    {
        $shipment->load(['order']); // relasi lain kalau ada

        $timeline = [
            [
                'label'  => 'Order Dibuat',
                'time'   => optional($shipment->order)->created_at,
                'active' => true,
            ],
            [
                'label'  => 'Diproses Gudang',
                'time'   => $shipment->processed_at ?? null,
                'active' => in_array($shipment->status, ['processed', 'on_delivery', 'delivered']),
            ],
            [
                'label'  => 'Dalam Pengiriman',
                'time'   => $shipment->shipped_at ?? null,
                'active' => in_array($shipment->status, ['on_delivery', 'delivered']),
            ],
            [
                'label'  => 'Terkirim ke Tujuan',
                'time'   => $shipment->delivered_at ?? null,
                'active' => $shipment->status === 'delivered',
            ],
        ];

        return view('admin.shipments.show', compact('shipment', 'timeline'));
    }
}
