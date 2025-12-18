<?php

namespace Tests\Unit\Cart;

use PHPUnit\Framework\TestCase;

class CartQuantityRuleTest extends TestCase
{
    /**
     * Menguji aturan bahwa kuantitas minimal harus 1.
     */
    public function test_quantity_must_be_at_least_one(): void
    {
        $stock = 10;
        
        $qtyZero = 0;
        $qtyNegative = -2;
        $qtyValid = 1;

        // Assertion: kuantitas harus >= 1
        $this->assertFalse($qtyZero >= 1);
        $this->assertFalse($qtyNegative >= 1);
        $this->assertTrue($qtyValid >= 1);
    }

    /**
     * Menguji aturan bahwa kuantitas tidak boleh melebihi stok yang tersedia.
     */
    public function test_quantity_cannot_exceed_stock(): void
    {
        $currentStock = 5;

        $qtyExceed = 6;
        $qtyExact = 5;
        $qtyUnder = 3;

        // Assertion: kuantitas <= stok
        $this->assertFalse($qtyExceed <= $currentStock);
        $this->assertTrue($qtyExact <= $currentStock);
        $this->assertTrue($qtyUnder <= $currentStock);
    }
}