<?php
// app/Models/Inventory.php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'stock'
    ];

    /**
     * Relasi Belongs To: Inventory dimiliki oleh satu Item.
     */
    public function Item()
    {
        return $this->belongsTo(Item::class);
    }
}