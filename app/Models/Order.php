<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount', // Sinkron dengan kolom di phpMyAdmin
        'shipping_address',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke OrderDetail.
     * Dibuat dua nama agar sinkron dengan UserController (items) 
     * dan OrderProcessController (details).
     */
    public function items()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    // Accessor untuk warna status badge
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'paid'      => 'background: #D1FAE5; color: #065F46;',
            'pending'   => 'background: #FEF3C7; color: #92400E;',
            'shipped'   => 'background: #DBEAFE; color: #1E40AF;',
            'cancelled' => 'background: #FEE2E2; color: #991B1B;',
            'completed' => 'background: #E0E7FF; color: #3730A3;',
            default     => 'background: #F3F4F6; color: #374151;'
        };
    }

    // eloquent

}