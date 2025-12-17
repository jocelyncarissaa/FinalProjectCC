<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'shipping_address',
        'status'
    ];

    /**
     * Pastikan fungsi ini ada agar OrderProcessController bisa memanggil 'details'
     */
    public function details()
    {
        // Parameter kedua adalah foreign key di tabel order_details
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    // Tambahkan juga relasi 'items' agar UserController tidak error
    public function items()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}