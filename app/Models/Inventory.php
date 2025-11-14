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

    // 1 Inventory has 1 Item
     
    public function Item()
    {
        return $this->belongsTo(Item::class);
    }
}