<?php

namespace Tests\Unit\Cart;

use PHPUnit\Framework\TestCase;
use App\Services\CartPriceService;

class StockValidationTest extends TestCase
{
    public function test_it_should_fail_when_purchase_quantity_exceeds_available_stock(): void
    {
        $service = new CartPriceService();
        
        $this->assertFalse($service->isStockSufficient(5, 2));
    }

    public function test_it_should_pass_when_purchase_quantity_is_within_stock_limits(): void
    {
        $service = new CartPriceService();
        $this->assertTrue($service->isStockSufficient(3, 10));
    }
}