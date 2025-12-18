<?php

namespace Tests\Unit\Order;

use PHPUnit\Framework\TestCase;

class OrderStatusTransitionTest extends TestCase
{
    /**
     * Skenario: Menguji transisi status yang valid dalam alur normal.
     */
    public function test_valid_order_status_transitions(): void
    {
        // Simulasi aturan: pending -> paid, paid -> shipped, shipped -> completed
        $transitions = [
            ['from' => 'pending', 'to' => 'paid'],
            ['from' => 'paid', 'to' => 'shipped'],
            ['from' => 'shipped', 'to' => 'completed'],
        ];

        foreach ($transitions as $transition) {
            $canTransition = $this->checkTransition($transition['from'], $transition['to']);
            $this->assertTrue($canTransition, "Gagal memvalidasi transisi dari {$transition['from']} ke {$transition['to']}");
        }
    }

    /**
     * Skenario: Menguji transisi terlarang (Invalid Transitions).
     */
    public function test_invalid_order_status_transitions(): void
    {
        // Simulasi aturan: Pesanan yang sudah 'cancelled' tidak boleh jadi 'shipped'
        // Pesanan yang sudah 'completed' tidak bisa di-'cancel'
        $invalidTransitions = [
            ['from' => 'cancelled', 'to' => 'shipped'],
            ['from' => 'completed', 'to' => 'cancelled'],
            ['from' => 'shipped', 'to' => 'pending'],
        ];

        foreach ($invalidTransitions as $transition) {
            $canTransition = $this->checkTransition($transition['from'], $transition['to']);
            $this->assertFalse($canTransition, "Harusnya dilarang: transisi dari {$transition['from']} ke {$transition['to']}");
        }
    }

    /**
     * Helper Method: Logika murni transisi status.
     * Biasanya di aplikasi nyata ini ada di dalam Service atau Model.
     */
    private function checkTransition(string $currentStatus, string $targetStatus): bool
    {
        $allowed = [
            'pending'   => ['paid', 'cancelled'],
            'paid'      => ['shipped', 'cancelled'],
            'shipped'   => ['completed'],
            'completed' => [], // Final state
            'cancelled' => [], // Final state
        ];

        return in_array($targetStatus, $allowed[$currentStatus] ?? []);
    }
}