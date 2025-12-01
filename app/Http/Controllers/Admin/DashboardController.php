<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Shipment;      // ⬅️ tambahkan ini
use Carbon\Carbon;           // ⬅️ dan ini

class DashboardController extends Controller
{
    public function index()
    {
        // =====================
        // INVENTORY SUMMARY
        // =====================

        // total item
        $totalMedicines = Item::count();

        // jumlah kategori unik
        $medicineGroups = Item::whereNotNull('category')
            ->distinct('category')
            ->count('category');

        // out of stock
        $outOfStock = Item::whereHas('inventory', function ($q) {
                $q->where('stock', '<=', 0);
            })
            ->count();

        // low stock
        $lowStock = Item::whereHas('inventory', function ($q) {
                $q->where('stock', '>', 0)
                  ->where('stock', '<=', 10);
            })
            ->count();

        // status inventory
        $inventoryStatus = ($outOfStock == 0 && $lowStock == 0)
            ? 'Good'
            : 'Need Attention';

        // =====================
        // SHIPMENT SUMMARY
        // =====================

        $pendingShipments   = Shipment::where('status', 'pending')->count();
        $deliveredShipments = Shipment::where('status', 'delivered')->count();
        $completedShipments = Shipment::where('status', 'completed')->count();

        // shipment yang dibuat hari ini
        $todayShipments = Shipment::whereDate('created_at', Carbon::today())->count();

        // kirim ke view
        return view('admin.dashboard', compact(
            'totalMedicines',
            'medicineGroups',
            'outOfStock',
            'lowStock',
            'inventoryStatus',
            'pendingShipments',
            'deliveredShipments',
            'completedShipments',
            'todayShipments'
        ));
    }
}
