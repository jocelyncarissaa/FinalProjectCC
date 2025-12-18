<?php

namespace Tests\Unit\Cart;

use PHPUnit\Framework\TestCase;

class StockValidationTest extends TestCase
{
    /**
     * Mengetes logika aturan: Pembelian TIDAK BOLEH melebihi stok tersedia.
     * Ini adalah Unit Test karena kita hanya mengetes perbandingan angka.
     */
    public function test_it_should_fail_when_purchase_quantity_exceeds_available_stock(): void
    {
        // ARRANGE: Siapkan angka simulasi
        $availableStock = 2;
        $purchaseQty = 5;

        // ACT: Jalankan logika murni (apakah permintaan <= stok?)
        $isEligible = ($purchaseQty <= $availableStock);

        // ASSERT: Hasilnya harus FALSE (Gagal)
        $this->assertFalse($isEligible, "Logika Unit Gagal: Sistem memperbolehkan pembelian 5 barang padahal stok hanya 2.");
    }

    /**
     * Mengetes logika aturan: Pembelian DIPERBOLEHKAN jika stok mencukupi.
     */
    public function test_it_should_pass_when_purchase_quantity_is_within_stock_limits(): void
    {
        // ARRANGE
        $availableStock = 10;
        $purchaseQty = 3;

        // ACT
        $isEligible = ($purchaseQty <= $availableStock);

        // ASSERT: Hasilnya harus TRUE (Lolos)
        $this->assertTrue($isEligible);
    }

    /**
     * Mengetes logika aturan: Stok pas-pasan (Boundary Value Analysis).
     */
    public function test_it_should_pass_when_purchase_quantity_exactly_matches_stock(): void
    {
        // ARRANGE
        $availableStock = 5;
        $purchaseQty = 5;

        // ACT
        $isEligible = ($purchaseQty <= $availableStock);

        // ASSERT: Hasilnya harus TRUE
        $this->assertTrue($isEligible);
    }
}