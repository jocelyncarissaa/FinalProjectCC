<?php

namespace App\Services;

class CheckoutService
{
    /**
     * Logika murni untuk mengecek apakah user layak lanjut ke checkout.
     */
    public function isEligible(array $cartItems, ?string $address): bool
    {
        // Syarat 1: Keranjang tidak boleh kosong
        $hasItems = !empty($cartItems);
        
        // Syarat 2: Alamat tidak boleh null atau kosong
        $hasAddress = !empty($address);

        return $hasItems && $hasAddress;
    }
}