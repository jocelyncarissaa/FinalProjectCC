<?php
// app/Models/Item.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Tambahkan semua kolom baru dari CSV ke fillable
    protected $fillable = [
        'name',
        'price',
        'category',
        'dosage_form',
        'strength',
        'manufacturer',
        'indication',
        'image_path'
    ];

    /**
     * Relasi One-to-One: Item memiliki satu data Stok (Inventory).
     */
    public function Inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    /**
     * Relasi One-to-Many: Item dapat berada di banyak OrderDetail.
     */
    public function OrderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}