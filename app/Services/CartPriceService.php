<?php

namespace App\Services;

class CartPriceService
{
    /**
     * Menghitung subtotal dari array item.
     */
    public function calculateSubtotal(array $items): float
    {
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += ($item['price'] * $item['qty']);
        }
        return $subtotal;
    }

    /**
     * Menghitung total akhir dengan diskon.
     */
    public function calculateTotalWithDiscount(float $subtotal, float $discountRate): float
    {
        return $subtotal - ($subtotal * $discountRate);
    }

    /**
     * Logika murni validasi stok (untuk digunakan di Unit Test).
     */
    public function isStockSufficient(int $requested, int $available): bool
    {
        return $requested <= $available && $requested >= 1;
    }
}