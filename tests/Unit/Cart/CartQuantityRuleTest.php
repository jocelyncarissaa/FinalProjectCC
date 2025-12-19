<?php

namespace Tests\Unit\Cart;

use PHPUnit\Framework\TestCase;
use App\Services\CartPriceService; 

class CartQuantityRuleTest extends TestCase
{
    /**
     * Menguji aturan bahwa kuantitas minimal harus 1.
     */
    public function test_quantity_must_be_at_least_one(): void
    {
        $service = new CartPriceService();
        $this->assertFalse($service->isStockSufficient(0, 10), 'Gagal: Qty 0 harusnya tidak valid');
        $this->assertFalse($service->isStockSufficient(-2, 10), 'Gagal: Qty negatif harusnya tidak valid');
        $this->assertTrue($service->isStockSufficient(1, 10), 'Berhasil: Qty 1 adalah batas minimal');
    }

    /**
     * Menguji aturan bahwa kuantitas tidak boleh melebihi stok yang tersedia.
     */
    public function test_quantity_cannot_exceed_stock(): void
    {
        $service = new CartPriceService();
        $this->assertFalse($service->isStockSufficient(6, 5), 'Gagal: Qty melebihi stok harusnya ditolak');
        $this->assertTrue($service->isStockSufficient(5, 5), 'Berhasil: Qty pas dengan stok diperbolehkan');
        $this->assertTrue($service->isStockSufficient(3, 5), 'Berhasil: Qty di bawah stok diperbolehkan');
    }
}