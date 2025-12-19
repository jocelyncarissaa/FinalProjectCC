<?php

namespace Tests\Unit\Order;

use PHPUnit\Framework\TestCase;
use App\Services\OrderStatusService;

class OrderStatusTransitionTest extends TestCase
{
    public function test_valid_order_status_transitions(): void
    {
        $service = new OrderStatusService();

        $this->assertTrue($service->canTransition('pending', 'paid'));
        $this->assertTrue($service->canTransition('paid', 'shipped'));
    }

    public function test_invalid_order_status_transitions(): void
    {
        $service = new OrderStatusService();

        // Pesanan yang sudah selesai tidak boleh dibatalkan
        $this->assertFalse($service->canTransition('completed', 'cancelled'));
        
        // Pesanan yang dikirim tidak boleh balik ke pending
        $this->assertFalse($service->canTransition('shipped', 'pending'));
    }
}