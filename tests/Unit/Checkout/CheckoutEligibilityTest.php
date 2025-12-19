<?php

namespace Tests\Unit\Checkout;

use PHPUnit\Framework\TestCase;
use App\Services\CheckoutService;

class CheckoutEligibilityTest extends TestCase
{
    public function test_cannot_checkout_with_empty_cart(): void
    {
        $service = new CheckoutService();
        $this->assertFalse($service->isEligible([], 'Jl. Mawar No. 1'));
    }

    public function test_cannot_checkout_without_shipping_address(): void
    {
        $service = new CheckoutService();
        $this->assertFalse($service->isEligible(['Item 1'], null));
    }

    public function test_can_checkout_with_items_and_address(): void
    {
        $service = new CheckoutService();
        $this->assertTrue($service->isEligible(['Item 1'], 'Jl. Mawar No. 1'));
    }
}