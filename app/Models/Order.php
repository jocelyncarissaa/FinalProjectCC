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

    /**
     * Relasi Belongs To: Order dimiliki oleh satu User (Customer).
     */
    public function user()
    {
        // Asumsi User Model adalah bawaan Laravel Auth
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi One-to-Many: Satu Order memiliki banyak OrderDetails (daftar barang).
     */
    public function OrderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Relasi One-to-One: Order memiliki satu Payment.
     */
    public function Payment()
    {
        return $this->hasOne(Payment::class);
    }
}