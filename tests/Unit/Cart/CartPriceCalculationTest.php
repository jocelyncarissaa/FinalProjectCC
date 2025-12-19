<?php

namespace Tests\Unit\Cart;

use PHPUnit\Framework\TestCase;
use App\Services\CartPriceService;

class CartPriceCalculationTest extends TestCase
{
    public function test_cart_subtotal_calculation(): void
    {
        $service = new CartPriceService();
        $items = [['price' => 50000, 'qty' => 3]];

        $this->assertEquals(150000, $service->calculateSubtotal($items));
    }

    public function test_cart_total_with_discount(): void
    {
        $service = new CartPriceService();
        $subtotal = 100000;
        
        $this->assertEquals(90000, $service->calculateTotalWithDiscount($subtotal, 0.1));
    }
}