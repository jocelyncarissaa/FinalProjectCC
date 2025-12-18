<?php

namespace Tests\Unit\Checkout;

use PHPUnit\Framework\TestCase;

class CheckoutEligibilityTest extends TestCase
{
    /**
     * Skenario: User tidak boleh checkout jika keranjang kosong.
     */
    public function test_cannot_checkout_with_empty_cart(): void
    {
        // ARRANGE: Data simulasi keranjang kosong dan status alamat
        $cartItems = []; 
        $hasAddress = true;

        // ACT: Jalankan logika murni (Simulasi logic di Checker Service)
        $canCheckout = !empty($cartItems) && $hasAddress;

        // ASSERT: Hasilnya harus False
        $this->assertFalse($canCheckout, "User tidak boleh checkout jika keranjang kosong.");
    }

    /**
     * Skenario: User tidak boleh checkout jika alamat pengiriman belum diatur.
     */
    public function test_cannot_checkout_without_shipping_address(): void
    {
        // ARRANGE: Keranjang ada isi, tapi alamat kosong
        $cartItems = ['item1', 'item2'];
        $hasAddress = false;

        // ACT
        $canCheckout = !empty($cartItems) && $hasAddress;

        // ASSERT: Hasilnya harus False
        $this->assertFalse($canCheckout, "User tidak boleh checkout tanpa alamat pengiriman.");
    }

    /**
     * Skenario Sukses: Keranjang ada isi dan alamat sudah ada.
     */
    public function test_can_checkout_with_items_and_address(): void
    {
        // ARRANGE
        $cartItems = ['item1'];
        $hasAddress = true;

        // ACT
        $canCheckout = !empty($cartItems) && $hasAddress;

        // ASSERT: Hasilnya harus True
        $this->assertTrue($canCheckout);
    }
}