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

    // // 1 Order has 1 Payment
    // public function Payment()
    // {
    //     return $this->hasOne(Payment::class);
    // }

    // Add this accessor
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'paid' => 'background: #D1FAE5; color: #065F46;', // Green
            'pending' => 'background: #FEF3C7; color: #92400E;', // Yellow/Orange
            'shipped' => 'background: #DBEAFE; color: #1E40AF;', // Blue
            'cancelled' => 'background: #FEE2E2; color: #991B1B;', // Red
            'completed' => 'background: #E0E7FF; color: #3730A3;', // Indigo
            default => 'background: #F3F4F6; color: #374151;' // Gray
        };
    }
}