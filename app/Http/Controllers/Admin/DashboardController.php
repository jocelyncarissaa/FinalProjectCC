<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Shipment;      // ⬅️ tambahkan ini
use Carbon\Carbon;           // ⬅️ dan ini
use App\Models\Order;

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

        // REVENUE CALCULATION
        // =====================
        
        // Calculate revenue for the current month
        // We filter by statuses that indicate money is received (paid, shipped, completed)
        $revenue = Order::whereIn('status', ['paid', 'shipped', 'completed']) //
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_amount'); // Using 'total_price' from Order model fillable

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
            'todayShipments',
            'revenue'
        ));

        
    }
}
