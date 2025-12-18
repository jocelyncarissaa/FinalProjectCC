<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class OrderTransactionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function stock_should_not_go_below_zero_on_checkout(): void
    {
        // ARRANGE
        $user = User::factory()->create();
        $item = Item::factory()->create();
        
        // Buat stok hanya 2
        Inventory::factory()->create([
            'item_id' => $item->id, 
            'stock' => 2
        ]);

        // Simulasi User memasukkan 5 barang (melebihi stok)
        Cart::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'quantity' => 5
        ]);

        // ACT
        $this->actingAs($user)->get(route('orders.execute'));

        // ASSERT
        $inventory = Inventory::where('item_id', $item->id)->first();
        
        // Cek apakah stok menjadi minus. 
        // Jika minus, testing ini akan FAIL dan itu bagus untuk menunjukkan bug stok!
        $this->assertGreaterThanOrEqual(0, $inventory->stock, "BUG: Stok menjadi minus!");
    }

    #[Test]
    public function user_cannot_view_other_users_order_detail(): void
    {
        // ARRANGE
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        
        $orderB = Order::create([
            'user_id' => $userB->id,
            'total_amount' => 100000,
            'status' => 'pending',
            'shipping_address' => 'Alamat User B'
        ]);

        // ACT
        $response = $this->actingAs($userA)->get("/profile/order/{$orderB->id}");

        // ASSERT
        // Jika sistem Anda belum punya proteksi, ini akan FAIL (dapat 200/404 bukan 403)
        $response->assertStatus(403);
    }

    #[Test]
    public function cart_is_emptied_only_after_successful_transaction(): void
    {
        // ARRANGE
        $user = User::factory()->create();
        $item = Item::factory()->create();
        Inventory::factory()->create(['item_id' => $item->id, 'stock' => 10]);

        Cart::create([
            'user_id' => $user->id, 
            'item_id' => $item->id, 
            'quantity' => 1
        ]);

        // ACT
        $this->actingAs($user)->get(route('orders.execute'));

        // ASSERT
        $this->assertDatabaseMissing('carts', ['user_id' => $user->id]);
    }
}