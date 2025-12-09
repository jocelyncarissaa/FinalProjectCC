<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller // PASTIKAN CLASS DEKLARASI DI SINI
{
    public function index(Request $request) {
        $query = Item::query();

        // Logika Pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
        }

        // Logika Filter Kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $items = $query->paginate(12)->withQueryString();

        return view('user.products.product_detail', compact('items'));
    }

    // ... method lain, seperti indexAdmin() atau show()
} // PASTIKAN KURUNG KURAWAL PENUTUP CLASS ADA