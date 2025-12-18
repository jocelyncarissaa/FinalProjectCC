<?php

namespace Tests\Unit\Cart;

use PHPUnit\Framework\TestCase;

class CartPriceCalculationTest extends TestCase
{
    /**
     * Menguji perhitungan subtotal dasar (Harga x Qty).
     */
    public function test_cart_subtotal_calculation(): void
    {
        $price = 50000;
        $quantity = 3;

        $subtotal = $price * $quantity;

        $this->assertEquals(150000, $subtotal);
    }

    /**
     * Menguji perhitungan total akhir setelah dipotong diskon.
     */
    public function test_cart_total_with_discount(): void
    {
        // Simulasi data barang di keranjang
        $items = [
            ['price' => 50000, 'qty' => 2], // Subtotal: 100.000
        ];
        
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += ($item['price'] * $item['qty']);
        }

        $discountRate = 0.1; // Diskon 10%
        $discountAmount = $subtotal * $discountRate;
        $total = $subtotal - $discountAmount;

        // Assertion: 100.000 - 10.000 = 90.000
        $this->assertEquals(90000, $total);
    }
}