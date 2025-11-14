<?php

// app/Models/OrderDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
        'price_per_unit'
    ];

    // 1 OrderDetail has 1 Order
    public function Order()
    {
        return $this->belongsTo(Order::class);
    }

    // 1 OrderDetail has 1 Item
    public function Item()
    {
        return $this->belongsTo(Item::class);
    }
}