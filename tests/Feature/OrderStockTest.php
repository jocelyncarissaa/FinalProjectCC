<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Inventory;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_logic_is_broken_allowing_negative_stock(): void
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $inventory = Inventory::create([
            'item_id' => $item->id,
            'stock' => 10
        ]);

        Cart::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'quantity' => 50
        ]);

        $this->actingAs($user)
             ->post(route('order.store')); 

        $inventoryBaru = Inventory::where('item_id', $item->id)->first();

        $this->assertGreaterThanOrEqual(
            0, 
            $inventoryBaru->stock, 
            "Gagal! Controller membiarkan stok menjadi minus ({$inventoryBaru->stock})"
        );
    }
}