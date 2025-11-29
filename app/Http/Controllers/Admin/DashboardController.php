<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;

class DashboardController extends Controller
{
    public function index()
    {
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

        return view('admin.dashboard', compact(
            'totalMedicines',
            'medicineGroups',
            'outOfStock',
            'lowStock',
            'inventoryStatus'
        ));
    }
}
