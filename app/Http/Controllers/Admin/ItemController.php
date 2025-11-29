<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // Tampilkan list semua item + fitur search
    public function index(Request $request)
    {
        // Ambil keyword dari query string (?search=...)
        $search = $request->input('search');

        // Base query, sekalian load relasi inventory karena dipakai di view
        $query = Item::with('inventory');

        // Kalau ada kata kunci, filter ke beberapa kolom
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('manufacturer', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('indication', 'like', "%{$search}%");
            });
        }

        // Urutkan & paginate, dengan withQueryString supaya ?search tetap ada saat pindah halaman
        $items = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Kirim juga variabel $search ke view (kalau mau dipakai untuk value input / teks info)
        return view('admin.items.index', compact('items', 'search'));
    }

    // Tampilkan form create item baru
    public function create()
    {
        return view('admin.items.create');
    }

    // Simpan item baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'price'        => ['required', 'numeric', 'min:0'],
            'category'     => ['nullable', 'string', 'max:100'],
            'dosage_form'  => ['nullable', 'string', 'max:100'],
            'strength'     => ['nullable', 'string', 'max:100'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'indication'   => ['nullable', 'string'],
            // sementara image_path disimpan sebagai teks (URL / path)
            'image_path'   => ['nullable', 'string', 'max:255'],
        ]);

        Item::create($validated);

        return redirect()
            ->route('admin.items.index')
            ->with('success', 'Item created successfully.');
    }

    // Tampilkan detail 1 item (opsional).
    public function show(Item $item)
    {
        return view('admin.items.show', compact('item'));
    }

    // Tampilkan form edit item.
    public function edit(Item $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    // Update item di database.
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'price'        => ['required', 'numeric', 'min:0'],
            'category'     => ['nullable', 'string', 'max:100'],
            'dosage_form'  => ['nullable', 'string', 'max:100'],
            'strength'     => ['nullable', 'string', 'max:100'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'indication'   => ['nullable', 'string'],
            'image_path'   => ['nullable', 'string', 'max:255'],
        ]);

        $item->update($validated);

        return redirect()
            ->route('admin.items.index')
            ->with('success', 'Item updated successfully.');
    }

    // Hapus item
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()
            ->route('admin.items.index')
            ->with('success', 'Item deleted successfully.');
    }
}
