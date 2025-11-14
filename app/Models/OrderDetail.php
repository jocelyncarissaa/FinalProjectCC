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

    /**
     * Relasi Belongs To: OrderDetail dimiliki oleh satu Order.
     */
    public function Order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi Belongs To: OrderDetail merujuk pada satu Item.
     */
    public function Item()
    {
        return $this->belongsTo(Item::class);
    }
}