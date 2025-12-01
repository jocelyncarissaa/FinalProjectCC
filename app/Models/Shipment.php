<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'order_id',
        'status',
        'processed_at',
        'shipped_at',
        'delivered_at',
        'tracking_code'
    ];

    protected $dates = [
        'processed_at',
        'shipped_at',
        'delivered_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}


