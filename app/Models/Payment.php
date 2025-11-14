<?php

// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'status'
    ];

    // 1 Payment has 1 Order
    public function Order()
    {
        return $this->belongsTo(Order::class);
    }
}