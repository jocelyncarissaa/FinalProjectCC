<?php

namespace App\Services;

class OrderStatusService
{
    /**
     * Definisi aturan transisi status pesanan.
     */
    protected $allowedTransitions = [
        'pending'   => ['paid', 'cancelled'],
        'paid'      => ['shipped', 'cancelled'],
        'shipped'   => ['completed'],
        'completed' => [], // Status akhir
        'cancelled' => [], // Status akhir
    ];

    /**
     * Mengecek apakah perubahan status diperbolehkan.
     */
    public function canTransition(string $currentStatus, string $targetStatus): bool
    {
        return in_array($targetStatus, $this->allowedTransitions[$currentStatus] ?? []);
    }
}