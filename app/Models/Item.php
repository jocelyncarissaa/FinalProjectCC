<?php
// app/Models/Item.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

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

    // 1 Item has 1 Stok/Inventory
    public function Inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    // 1 Item has many OrderDetails
    public function OrderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
