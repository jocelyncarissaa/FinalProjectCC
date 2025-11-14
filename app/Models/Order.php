<?php
// app/Models/Order.php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'shipping_address',
        'status'
    ];

    // 1 Order has 1 User/Customer
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 1 Order has many OrderDetails
    public function OrderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // 1 Order has 1 Payment
    public function Payment()
    {
        return $this->hasOne(Payment::class);
    }
}